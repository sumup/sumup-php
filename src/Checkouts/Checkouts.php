<?php

declare(strict_types=1);

namespace SumUp\Checkouts;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class CheckoutsListAvailablePaymentMethodsResponse
{
    /**
     *
     * @var array[]|null
     */
    public ?array $availablePaymentMethods = null;

}

/**
 * Query parameters for CheckoutsListParams.
 *
 * @package SumUp\Services
 */
class CheckoutsListParams
{
    /**
     * Filters the list of checkout resources by the unique ID of the checkout.
     *
     * @var string|null
     */
    public ?string $checkoutReference = null;

}

/**
 * Query parameters for CheckoutsListAvailablePaymentMethodsParams.
 *
 * @package SumUp\Services
 */
class CheckoutsListAvailablePaymentMethodsParams
{
    /**
     * The amount for which the payment methods should be eligible, in major units. Note that currency must also be provided when filtering by amount.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * The currency for which the payment methods should be eligible.
     *
     * @var string|null
     */
    public ?string $currency = null;

}

/**
 * Class Checkouts
 *
 * @package SumUp\Services
 */
class Checkouts implements SumUpService
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
     * Checkouts constructor.
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
     * Create a checkout
     *
     * @param \SumUp\Types\CheckoutCreateRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Checkout
     */
    public function create(\SumUp\Types\CheckoutCreateRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Checkout
    {
        $path = '/v0.1/checkouts';
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Checkout::class],
        ], [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\ErrorExtended::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\ErrorForbidden::class],
            '409' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'POST', $path);
    }

    /**
     * Deactivate a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Checkout
     */
    public function deactivate(string $id, ?array $requestOptions = null): \SumUp\Types\Checkout
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Checkout::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '409' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'DELETE', $path);
    }

    /**
     * Retrieve a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\CheckoutSuccess
     */
    public function get(string $id, ?array $requestOptions = null): \SumUp\Types\CheckoutSuccess
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\CheckoutSuccess::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * List checkouts
     *
     * @param CheckoutsListParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\CheckoutSuccess[]
     */
    public function list(?CheckoutsListParams $queryParams = null, ?array $requestOptions = null): array
    {
        $path = '/v0.1/checkouts';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->checkoutReference)) {
                $queryParamsData['checkout_reference'] = $queryParams->checkoutReference;
            }
            if (!empty($queryParamsData)) {
                $queryString = http_build_query($queryParamsData);
                if (!empty($queryString)) {
                    $path .= '?' . $queryString;
                }
            }
        }
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Types\CheckoutSuccess::class]],
        ], [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * Get available payment methods
     *
     * @param string $merchantCode The SumUp merchant code.
     * @param CheckoutsListAvailablePaymentMethodsParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Services\CheckoutsListAvailablePaymentMethodsResponse
     */
    public function listAvailablePaymentMethods(string $merchantCode, ?CheckoutsListAvailablePaymentMethodsParams $queryParams = null, ?array $requestOptions = null): \SumUp\Services\CheckoutsListAvailablePaymentMethodsResponse
    {
        $path = sprintf('/v0.1/merchants/%s/payment-methods', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->amount)) {
                $queryParamsData['amount'] = $queryParams->amount;
            }
            if (isset($queryParams->currency)) {
                $queryParamsData['currency'] = $queryParams->currency;
            }
            if (!empty($queryParamsData)) {
                $queryString = http_build_query($queryParamsData);
                if (!empty($queryString)) {
                    $path .= '?' . $queryString;
                }
            }
        }
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Services\CheckoutsListAvailablePaymentMethodsResponse::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\DetailsError::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * Process a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     * @param \SumUp\Types\ProcessCheckout|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\CheckoutSuccess|\SumUp\Types\CheckoutAccepted
     */
    public function process(string $id, \SumUp\Types\ProcessCheckout|array $body, ?array $requestOptions = null): \SumUp\Types\CheckoutSuccess|\SumUp\Types\CheckoutAccepted
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Types\CheckoutSuccess::class],
            '202' => ['type' => 'class', 'class' => \SumUp\Types\CheckoutAccepted::class],
        ], [
            '400' => ['type' => 'mixed'],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '409' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'PUT', $path);
    }
}
