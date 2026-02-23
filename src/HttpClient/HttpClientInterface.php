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
     * @param array<int|string, mixed> $body        The body of the request.
     * @param array<string, string> $headers     The headers of the request.
     * @param array<string, mixed>|null $options Optional request options (timeout, connect_timeout, retries, retry_backoff_ms).
     *
     * @return Response
     */
    public function send(string $method, string $url, array $body, array $headers, ?array $options = null): Response;
}
