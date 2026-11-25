<?php

declare(strict_types=1);

namespace SumUp\ReaderSettings;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\HttpClient\RequestHeaders;
use SumUp\HttpClient\RequestOptions;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;

/**
 * Class ReaderSettings
 *
 * Retrieve and update card reader settings.
 *
 * @package SumUp\Services
 */
class ReaderSettings implements SumUpService
{
    /**
     * The client for the http communication.
     *
     * @var HttpClientInterface
     */
    protected HttpClientInterface $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected string $accessToken;

    /**
     * ReaderSettings constructor.
     *
     * @param HttpClientInterface $client
     * @param string $accessToken
     */
    public function __construct(HttpClientInterface $client, string $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Get Reader Settings
     *
     * @param string $merchantCode The merchant code of the account that owns the reader.
     * @param string $readerId The unique identifier of the reader.
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\GetReaderSettingsResponse
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function get(string $merchantCode, string $readerId, ?RequestOptions $requestOptions = null): \SumUp\Types\GetReaderSettingsResponse
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/settings', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        $headers = RequestHeaders::build($this->accessToken, $requestOptions);

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\GetReaderSettingsResponse::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '422' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * Update Reader Settings
     *
     * @param string $merchantCode The merchant code of the account that owns the reader.
     * @param string $readerId The unique identifier of the reader.
     * @param \SumUp\Types\UpdateReaderSettingsRequest|array<string, mixed> $body Required request payload
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\UpdateReaderSettingsResponse
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function update(string $merchantCode, string $readerId, \SumUp\Types\UpdateReaderSettingsRequest|array $body, ?RequestOptions $requestOptions = null): \SumUp\Types\UpdateReaderSettingsResponse
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/settings', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        $requestBody = $body;
        if (is_array($requestBody)) {
            $requestBody = \SumUp\Types\UpdateReaderSettingsRequest::fromArray($requestBody);
        }
        $payload = RequestEncoder::encode($requestBody);
        $headers = RequestHeaders::build($this->accessToken, $requestOptions);

        $response = $this->client->send('PATCH', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\UpdateReaderSettingsResponse::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '422' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'PATCH', $path);
    }
}
