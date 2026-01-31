<?php

namespace SumUp\HttpClient;

/**
 * Interface HttpClientInterface
 *
 * @package SumUp\HttpClient
 */
interface HttpClientInterface
{
    /**
     * @param string $method      The request method.
     * @param string $url         The endpoint to send the request to.
     * @param array  $body        The body of the request.
     * @param array  $headers     The headers of the request.
     * @param array|null $options Optional request options (timeout, connect_timeout, retries, retry_backoff_ms).
     *
     * @return Response|mixed
     */
    public function send($method, $url, $body, $headers, $options = null);
}
