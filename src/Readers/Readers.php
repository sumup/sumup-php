<?php

declare(strict_types=1);

namespace SumUp\Readers;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class ListV01MerchantsMerchantCodeReadersGetResponse
{
    /**
     *
     * @var \SumUp\Types\Reader[]
     */
    public array $items;

}

class ReadersCreateRequest
{
    /**
     * The pairing code is a 8 or 9 character alphanumeric string that is displayed on a SumUp Device after initiating the pairing. It is used to link the physical device to the created pairing.
     *
     * @var string
     */
    public string $pairingCode;

    /**
     * Custom human-readable, user-defined name for easier identification of the reader.
     *
     * @var string
     */
    public string $name;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array|null
     */
    public ?array $metadata = null;

}

class ReadersUpdateRequest
{
    /**
     * Custom human-readable, user-defined name for easier identification of the reader.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array|null
     */
    public ?array $metadata = null;

}

/**
 * Class Readers
 *
 * @package SumUp\Services
 */
class Readers implements SumUpService
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
     * Readers constructor.
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
     * Create a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param ReadersCreateRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Reader
     */
    public function create(string $merchantCode, ReadersCreateRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Reader
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Reader::class],
        ], [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '409' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'POST', $path);
    }

    /**
     * Create a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param \SumUp\Types\CreateReaderCheckoutRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\CreateReaderCheckoutResponse
     */
    public function createCheckout(string $merchantCode, string $readerId, \SumUp\Types\CreateReaderCheckoutRequest|array $body, ?array $requestOptions = null): \SumUp\Types\CreateReaderCheckoutResponse
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/checkout', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderCheckoutResponse::class],
        ], [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderCheckoutError::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderCheckoutError::class],
            '422' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderCheckoutUnprocessableEntity::class],
            '500' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderCheckoutError::class],
            '502' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderCheckoutError::class],
            '504' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderCheckoutError::class],
        ], 'POST', $path);
    }

    /**
     * Delete a reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return null
     */
    public function delete(string $merchantCode, string $id, ?array $requestOptions = null): null
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'void'],
        ], [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'DELETE', $path);
    }

    /**
     * Retrieve a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Reader
     */
    public function get(string $merchantCode, string $id, ?array $requestOptions = null): \SumUp\Types\Reader
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Reader::class, [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * Get a Reader Status
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\StatusResponse
     */
    public function getStatus(string $merchantCode, string $readerId, ?array $requestOptions = null): \SumUp\Types\StatusResponse
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/status', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\StatusResponse::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\BadRequest::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Unauthorized::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\NotFound::class],
            '500' => ['type' => 'class', 'class' => \SumUp\Types\InternalServerError::class],
            '502' => ['type' => 'class', 'class' => \SumUp\Types\BadGateway::class],
            '504' => ['type' => 'class', 'class' => \SumUp\Types\GatewayTimeout::class],
        ], 'GET', $path);
    }

    /**
     * List Readers
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Services\ListV01MerchantsMerchantCodeReadersGetResponse
     */
    public function list(string $merchantCode, ?array $requestOptions = null): \SumUp\Services\ListV01MerchantsMerchantCodeReadersGetResponse
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Services\ListV01MerchantsMerchantCodeReadersGetResponse::class, null, 'GET', $path);
    }

    /**
     * Terminate a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $body Optional request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return null
     */
    public function terminateCheckout(string $merchantCode, string $readerId, ?array $body = null, ?array $requestOptions = null): null
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/terminate', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        if ($body !== null) {
            $payload = RequestEncoder::encode($body);
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '202' => ['type' => 'void'],
        ], [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderTerminateError::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderTerminateError::class],
            '422' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderTerminateUnprocessableEntity::class],
            '500' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderTerminateError::class],
            '502' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderTerminateError::class],
            '504' => ['type' => 'class', 'class' => \SumUp\Types\CreateReaderTerminateError::class],
        ], 'POST', $path);
    }

    /**
     * Update a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     * @param ReadersUpdateRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Reader
     */
    public function update(string $merchantCode, string $id, ReadersUpdateRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Reader
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PATCH', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Reader::class, [
            '403' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'PATCH', $path);
    }
}
