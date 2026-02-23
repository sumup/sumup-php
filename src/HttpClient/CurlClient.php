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
     * @var string
     */
    private string $baseUrl;

    /**
     * Custom headers for every request.
     *
     * @var array<string, string>
     */
    private array $customHeaders;

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
     * @param array<string, string> $customHeaders
     * @param string|null $caBundlePath
     */
    public function __construct(string $baseUrl, array $customHeaders = [], ?string $caBundlePath = null)
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
     * @param array<int|string, mixed> $body        The body of the request.
     * @param array<string, string> $headers     The headers of the request.
     * @param array<string, mixed>|null $options Optional request options (timeout, connect_timeout, retries, retry_backoff_ms).
     *
     * @return Response
     *
     * @throws ConnectionException
     * @throws SDKException
     */
    public function send(string $method, string $url, array $body, array $headers = [], ?array $options = null): Response
    {
        if ($method === '') {
            throw new SDKException('Request method cannot be empty.');
        }

        $requestUrl = $this->baseUrl . $url;
        if ($requestUrl === '') {
            throw new SDKException('Request URL cannot be empty.');
        }

        $reqHeaders = array_merge($headers, $this->customHeaders);
        $requestOptions = is_array($options) ? $options : [];
        $retries = isset($requestOptions['retries']) ? (int) $requestOptions['retries'] : 0;
        $backoffMs = isset($requestOptions['retry_backoff_ms']) ? (int) $requestOptions['retry_backoff_ms'] : 0;

        $attempt = 0;
        do {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_URL, $requestUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($reqHeaders));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if (!empty($body)) {
                $payload = json_encode($body);
                if (!is_string($payload)) {
                    throw new SDKException('Failed to encode request body to JSON.');
                }
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

            if (!is_string($response)) {
                throw new ConnectionException('Unexpected empty response body from cURL request.', $code);
            }

            return new Response($code, $this->parseBody($response));
        } while (true);
    }

    /**
     * Format the headers to be compatible with cURL.
     *
     * @param array<string, string>|null $headers
     *
     * @return array<int, string>
     */
    private function formatHeaders(?array $headers = null): array
    {
        if (empty($headers)) {
            return [];
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
    private function parseBody(string $response)
    {
        $jsonBody = json_decode($response, true);
        if (isset($jsonBody)) {
            return $jsonBody;
        }
        return $response;
    }

    /**
     * Close the cURL handle.
     */
    private function closeHandle(\CurlHandle $handle): void
    {
        curl_close($handle);
    }

    /**
     * @param int $backoffMs
     * @param int $attempt
     */
    private function sleepBackoff(int $backoffMs, int $attempt): void
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
    private function normalizeCABundlePath(?string $caBundlePath): ?string
    {
        if ($caBundlePath === null || $caBundlePath === '') {
            return null;
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
    private function getDefaultCABundlePath(): ?string
    {
        $path = realpath(__DIR__ . '/../../resources/ca-bundle.crt');
        if ($path && is_readable($path)) {
            return $path;
        }

        return null;
    }
}
