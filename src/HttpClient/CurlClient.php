<?php

namespace SumUp\HttpClient;

use SumUp\Exception\ConfigurationException;
use SumUp\Exception\ConnectionException;
use SumUp\Exception\SDKException;

/**
 * Class CurlClient
 *
 * @package SumUp\HttpClient
 */
class CurlClient implements HttpClientInterface
{
    /**
     * The base URL.
     *
     * @var $baseUrl
     */
    private $baseUrl;

    /**
     * Custom headers for every request.
     *
     * @var $customHeaders
     */
    private $customHeaders;

    /**
     * The CA bundle path used to verify HTTPS calls.
     *
     * @var string|null
     */
    private $caBundlePath;

    /**
     * CurlClient constructor.
     *
     * @param string $baseUrl
     * @param array $customHeaders
     * @param string|null $caBundlePath
     */
    public function __construct($baseUrl, $customHeaders = [], $caBundlePath = null)
    {
        $this->baseUrl = $baseUrl;
        $this->customHeaders = $customHeaders;
        $this->caBundlePath = $this->normalizeCABundlePath($caBundlePath);
        if ($this->caBundlePath === null) {
            $this->caBundlePath = $this->getDefaultCABundlePath();
        }
    }

    /**
     * @param string $method      The request method.
     * @param string $url         The endpoint to send the request to.
     * @param array  $body        The body of the request.
     * @param array  $headers     The headers of the request.
     *
     * @return Response
     *
     * @throws ConnectionException
     * @throws \SumUp\Exception\AuthenticationException
     * @throws \SumUp\Exception\ValidationException
     * @throws SDKException
     */
    public function send($method, $url, $body, $headers = [], $options = null)
    {
        $reqHeaders = array_merge($headers, $this->customHeaders);
        $requestOptions = is_array($options) ? $options : [];
        $retries = isset($requestOptions['retries']) ? (int) $requestOptions['retries'] : 0;
        $backoffMs = isset($requestOptions['retry_backoff_ms']) ? (int) $requestOptions['retry_backoff_ms'] : 0;

        $attempt = 0;
        do {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($reqHeaders));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if (!empty($body)) {
                $payload = json_encode($body);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            }

            if (!empty($this->caBundlePath)) {
                curl_setopt($ch, CURLOPT_CAINFO, $this->caBundlePath);
            }

            if (isset($requestOptions['timeout'])) {
                curl_setopt($ch, CURLOPT_TIMEOUT, (int) $requestOptions['timeout']);
            }

            if (isset($requestOptions['connect_timeout'])) {
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, (int) $requestOptions['connect_timeout']);
            }

            $response = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $error = curl_error($ch);
            if ($error) {
                $this->closeHandle($ch);
                if ($attempt < $retries) {
                    $this->sleepBackoff($backoffMs, $attempt);
                    $attempt++;
                    continue;
                }
                throw new ConnectionException($error, $code);
            }

            $this->closeHandle($ch);
            if ($code >= 500 && $attempt < $retries) {
                $this->sleepBackoff($backoffMs, $attempt);
                $attempt++;
                continue;
            }

            return new Response($code, $this->parseBody($response));
        } while (true);
    }

    /**
     * Format the headers to be compatible with cURL.
     *
     * @param array|null $headers
     *
     * @return array
     */
    private function formatHeaders($headers = null)
    {
        if (count($headers) == 0) {
            return $headers;
        }

        $keys = array_keys($headers);
        $formattedHeaders = [];
        foreach ($keys as $key) {
            $formattedHeaders[] = $key . ': ' . $headers[$key];
        }
        return $formattedHeaders;
    }

    /**
     * Returns JSON encoded the response's body if it is of JSON type.
     *
     * @param $response
     *
     * @return mixed
     */
    private function parseBody($response)
    {
        $jsonBody = json_decode($response, true);
        if (isset($jsonBody)) {
            return $jsonBody;
        }
        return $response;
    }

    /**
     * Close the cURL handle when running on PHP versions where it is required.
     *
     * @param resource|\CurlHandle $handle
     */
    private function closeHandle($handle)
    {
        if (PHP_VERSION_ID < 80000 && is_resource($handle)) {
            curl_close($handle);
        }
    }

    /**
     * @param int $backoffMs
     * @param int $attempt
     */
    private function sleepBackoff($backoffMs, $attempt)
    {
        if ($backoffMs <= 0) {
            return;
        }

        $delay = $backoffMs * (int) pow(2, $attempt);
        usleep($delay * 1000);
    }

    /**
     * Normalize and validate the CA bundle path.
     *
     * @param string|null $caBundlePath
     *
     * @return string|null
     *
     * @throws ConfigurationException
     */
    private function normalizeCABundlePath($caBundlePath)
    {
        if ($caBundlePath === null || $caBundlePath === '') {
            return null;
        }

        if (!is_string($caBundlePath)) {
            throw new ConfigurationException('Invalid value for "ca_bundle_path". Expected string path or null.');
        }

        if (!is_readable($caBundlePath)) {
            throw new ConfigurationException(sprintf('The provided ca_bundle_path "%s" is not readable.', $caBundlePath));
        }

        return $caBundlePath;
    }

    /**
     * Returns the path to the CA bundle shipped with the SDK, if present.
     *
     * @return string|null
     */
    private function getDefaultCABundlePath()
    {
        $path = realpath(__DIR__ . '/../../resources/ca-bundle.crt');
        if ($path && is_readable($path)) {
            return $path;
        }

        return null;
    }
}
