<?php

namespace SumUp\HttpClient;

/**
 * Class Response
 *
 * @package SumUp\HttpClient
 */
class Response
{
    /**
     * The HTTP response code.
     *
     * @var number
     */
    protected int $httpResponseCode;

    /**
     * The response body.
     *
     * @var mixed
     */
    protected mixed $body;

    /**
     * Response constructor.
     *
     * @param int $httpResponseCode
     * @param mixed $body
     *
     */
    public function __construct(int $httpResponseCode, mixed $body)
    {
        $this->httpResponseCode = $httpResponseCode;
        $this->body = $body;
    }

    /**
     * Get HTTP response code.
     *
     * @return number
     */
    public function getHttpResponseCode(): int
    {
        return $this->httpResponseCode;
    }

    /**
     * Get the response body.
     *
     * @return array|mixed
     */
    public function getBody(): mixed
    {
        return $this->body;
    }

}
