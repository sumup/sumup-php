<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

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
     * @var SumUpHttpClientInterface
     */
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * Customers constructor.
     *
     * @param SumUpHttpClientInterface $client
     * @param AccessToken $accessToken
     */
    public function __construct(SumUpHttpClientInterface $client, AccessToken $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Create a customer
     *
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Customers\Customer
     */
    public function create($body = null)
    {
        $path = '/v0.1/customers';
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Customers\Customer::class],
        ]);
    }

    /**
     * Deactivate a payment instrument
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param string $token Unique token identifying the card saved as a payment instrument resource.
     *
     * @return null
     */
    public function deactivatePaymentInstrument($customerId, $token)
    {
        $path = sprintf('/v0.1/customers/%s/payment-instruments/%s', rawurlencode((string) $customerId), rawurlencode((string) $token));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '204' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a customer
     *
     * @param string $customerId Unique ID of the saved customer resource.
     *
     * @return \SumUp\Customers\Customer
     */
    public function get($customerId)
    {
        $path = sprintf('/v0.1/customers/%s', rawurlencode((string) $customerId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Customers\Customer::class],
        ]);
    }

    /**
     * List payment instruments
     *
     * @param string $customerId Unique ID of the saved customer resource.
     *
     * @return \SumUp\Customers\PaymentInstrumentResponse[]
     */
    public function listPaymentInstruments($customerId)
    {
        $path = sprintf('/v0.1/customers/%s/payment-instruments', rawurlencode((string) $customerId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Customers\PaymentInstrumentResponse::class]],
        ]);
    }

    /**
     * Update a customer
     *
     * @param string $customerId Unique ID of the saved customer resource.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Customers\Customer
     */
    public function update($customerId, $body = null)
    {
        $path = sprintf('/v0.1/customers/%s', rawurlencode((string) $customerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Customers\Customer::class],
        ]);
    }
}
