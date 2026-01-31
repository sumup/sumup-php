<?php

namespace SumUp\Exception;

/**
 * Class SDKException
 *
 * @package SumUp\Exception
 */
class SDKException extends \Exception
{
    /**
     * HTTP status code returned by the API, if any.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * Parsed response body or raw string when the response is not JSON.
     *
     * @var mixed
     */
    protected $responseBody;

    /**
     * @param string             $message
     * @param int                $statusCode
     * @param mixed              $responseBody
     * @param \Exception|null    $previous
     */
    public function __construct($message = '', $statusCode = 0, $responseBody = null, $previous = null)
    {
        parent::__construct($message, (int) $statusCode, $previous);

        $this->statusCode = (int) $statusCode;
        $this->responseBody = $responseBody;
    }

    /**
     * Returns the HTTP status code provided by the API, or 0 when absent.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Returns the decoded response body or the raw string payload.
     *
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }
}
