<?php

declare(strict_types=1);

namespace SumUp\Customers;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class CustomersUpdateRequest
{
    /**
     * Personal details for the customer.
     *
     * @var \SumUp\Types\PersonalDetails|null
     */
    public ?\SumUp\Types\PersonalDetails $personalDetails = null;

}

/**
 * Class Customers
 *
 * @package SumUp\Services
 */
class Customers implements SumUpService
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
     * Customers constructor.
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
     * Create a customer
     *
     * @param \SumUp\Types\Customer|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Customer
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\AuthenticationException
     * @throws \SumUp\Exception\ValidationException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function create(\SumUp\Types\Customer|array $body, ?array $requestOptions = null): \SumUp\Types\Customer
    {
        $path = '/v0.1/customers';
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Customer::class],
        ], [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\ErrorForbidden::class],
            '409' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'POST', $path);
    }

    /**
     * Deactivate a payment instrument
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param string $token Unique token identifying the card saved as a payment instrument resource.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return null
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\AuthenticationException
     * @throws \SumUp\Exception\ValidationException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function deactivatePaymentInstrument(string $customerId, string $token, ?array $requestOptions = null): null
    {
        $path = sprintf('/v0.1/customers/%s/payment-instruments/%s', rawurlencode((string) $customerId), rawurlencode((string) $token));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '204' => ['type' => 'void'],
        ], [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\ErrorForbidden::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'DELETE', $path);
    }

    /**
     * Retrieve a customer
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Customer
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\AuthenticationException
     * @throws \SumUp\Exception\ValidationException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function get(string $customerId, ?array $requestOptions = null): \SumUp\Types\Customer
    {
        $path = sprintf('/v0.1/customers/%s', rawurlencode((string) $customerId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Customer::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\ErrorForbidden::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * List payment instruments
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\PaymentInstrumentResponse[]
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\AuthenticationException
     * @throws \SumUp\Exception\ValidationException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function listPaymentInstruments(string $customerId, ?array $requestOptions = null): array
    {
        $path = sprintf('/v0.1/customers/%s/payment-instruments', rawurlencode((string) $customerId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Types\PaymentInstrumentResponse::class]],
        ], [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\ErrorForbidden::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * Update a customer
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param CustomersUpdateRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Customer
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\AuthenticationException
     * @throws \SumUp\Exception\ValidationException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function update(string $customerId, CustomersUpdateRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Customer
    {
        $path = sprintf('/v0.1/customers/%s', rawurlencode((string) $customerId));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Customer::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\ErrorForbidden::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'PUT', $path);
    }
}
