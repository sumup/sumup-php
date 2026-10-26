<?php

namespace SumUp\Exception;

use SumUp\HttpClient\Response;
use SumUp\Types\Problem;

/**
 * Represents an API error decoded from a non-2xx response.
 */
class ApiException extends SDKException
{
    /**
     * @var string|null
     */
    protected ?string $httpMethod;

    /**
     * @var string|null
     */
    protected ?string $path;

    private ?Response $response;

    public function __construct(
        string $message = '',
        int $statusCode = 0,
        mixed $responseBody = null,
        ?string $httpMethod = null,
        ?string $path = null,
        ?\Throwable $previous = null,
        ?Response $response = null
    ) {
        parent::__construct($message, $statusCode, $responseBody, $previous);
        $this->httpMethod = $httpMethod;
        $this->path = $path;
        $this->response = $response;
    }

    public function getHttpMethod(): ?string
    {
        return $this->httpMethod;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    /** Typed Problem details, when the API returned a Problem response. */
    public function getProblem(): ?Problem
    {
        $body = $this->getResponseBody();
        return $body instanceof Problem ? $body : null;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }
}
