<?php

namespace SumUp\HttpClient;

/**
 * Typed request options for HTTP calls.
 */
class RequestOptions
{
    /**
     * Total request timeout in seconds.
     *
     * @var int|null
     */
    public ?int $timeout = null;

    /**
     * Connection timeout in seconds.
     *
     * @var int|null
     */
    public ?int $connectTimeout = null;

    /**
     * Number of retry attempts for transient failures.
     *
     * @var int|null
     */
    public ?int $retries = null;

    /**
     * Base retry backoff in milliseconds.
     *
     * @var int|null
     */
    public ?int $retryBackoffMs = null;

    public function __construct(
        ?int $timeout = null,
        ?int $connectTimeout = null,
        ?int $retries = null,
        ?int $retryBackoffMs = null
    ) {
        $this->timeout = $timeout;
        $this->connectTimeout = $connectTimeout;
        $this->retries = $retries;
        $this->retryBackoffMs = $retryBackoffMs;
    }
}
