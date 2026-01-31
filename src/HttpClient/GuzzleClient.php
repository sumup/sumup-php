<?php

namespace SumUp\HttpClient;

use SumUp\Exception\ConfigurationException;
use SumUp\Exception\ConnectionException;

/**
 * Guzzle-based HTTP client (optional dependency).
 */
class GuzzleClient implements HttpClientInterface
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var array
     */
    private $customHeaders;

    /**
     * @var string|null
     */
    private $caBundlePath;

    /**
     * GuzzleClient constructor.
     *
     * @param string $baseUrl
     * @param array $customHeaders
     * @param string|null $caBundlePath
     *
     * @throws ConfigurationException
     */
    public function __construct($baseUrl, $customHeaders = [], $caBundlePath = null)
    {
        $this->ensureGuzzleInstalled();

        $this->baseUrl = $baseUrl;
        $this->customHeaders = $customHeaders;
        $this->caBundlePath = $caBundlePath;
    }

    /**
     * @param string $method      The request method.
     * @param string $url         The endpoint to send the request to.
     * @param array  $body        The body of the request.
     * @param array  $headers     The headers of the request.
     * @param array|null $options Optional request options (timeout, connect_timeout, retries, retry_backoff_ms).
     *
     * @return Response
     *
     * @throws ConnectionException
     * @throws \SumUp\Exception\AuthenticationException
     * @throws \SumUp\Exception\ValidationException
     * @throws \SumUp\Exception\SDKException
     */
    public function send($method, $url, $body, $headers, $options = null)
    {
        $this->ensureGuzzleInstalled();

        $requestOptions = is_array($options) ? $options : [];
        $reqHeaders = array_merge($headers, $this->customHeaders);
        $retries = isset($requestOptions['retries']) ? (int) $requestOptions['retries'] : 0;
        $backoffMs = isset($requestOptions['retry_backoff_ms']) ? (int) $requestOptions['retry_backoff_ms'] : 0;

        $handler = \GuzzleHttp\HandlerStack::create();
        if ($retries > 0) {
            $handler->push(\GuzzleHttp\Middleware::retry(
                function ($retry, $request, $response = null, $exception = null) use ($retries) {
                    if ($retry >= $retries) {
                        return false;
                    }
                    if ($exception !== null) {
                        return true;
                    }
                    if ($response && $response->getStatusCode() >= 500) {
                        return true;
                    }
                    return false;
                },
                function ($retry) use ($backoffMs) {
                    if ($backoffMs <= 0) {
                        return 0;
                    }
                    return (int) ($backoffMs * pow(2, $retry));
                }
            ));
        }

        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'handler' => $handler,
            'http_errors' => false,
            'verify' => $this->caBundlePath ?: true,
        ]);

        $requestParams = ['headers' => $reqHeaders];

        if (!empty($body)) {
            $requestParams['json'] = $body;
        }

        if (isset($requestOptions['timeout'])) {
            $requestParams['timeout'] = (int) $requestOptions['timeout'];
        }

        if (isset($requestOptions['connect_timeout'])) {
            $requestParams['connect_timeout'] = (int) $requestOptions['connect_timeout'];
        }

        try {
            $response = $client->request($method, $url, $requestParams);
        } catch (\GuzzleHttp\Exception\RequestException $exception) {
            if ($exception->hasResponse()) {
                $response = $exception->getResponse();
            } else {
                throw new ConnectionException($exception->getMessage(), $exception->getCode());
            }
        }

        $statusCode = $response->getStatusCode();
        $responseBody = (string) $response->getBody();
        $parsedBody = $this->parseBody($responseBody);

        return new Response($statusCode, $parsedBody);
    }

    /**
     * @param string $response
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
     * @throws ConfigurationException
     */
    private function ensureGuzzleInstalled()
    {
        if (!class_exists('\\GuzzleHttp\\Client')) {
            throw new ConfigurationException(
                'Guzzle is not installed. Run `composer require guzzlehttp/guzzle` to use SumUp\\HttpClient\\GuzzleClient.'
            );
        }
    }
}
