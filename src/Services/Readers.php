<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

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
     * @var SumUpHttpClientInterface
     */
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Readers constructor.
     *
     * @param SumUpHttpClientInterface $client
     * @param $accessToken
     */
    public function __construct(SumUpHttpClientInterface $client, $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Create a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Readers\Reader
     */
    public function create($merchantCode, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Readers\Reader::class],
        ]);
    }

    /**
     * Create a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Readers\CreateReaderCheckoutResponse
     */
    public function createCheckout($merchantCode, $readerId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/checkout', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Readers\CreateReaderCheckoutResponse::class],
        ]);
    }

    /**
     * Delete a reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     *
     * @return null
     */
    public function delete($merchantCode, $id)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     *
     * @return \SumUp\Readers\Reader
     */
    public function get($merchantCode, $id)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Readers\Reader::class);
    }

    /**
     * Get a Reader Status
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     *
     * @return \SumUp\Readers\StatusResponse
     */
    public function getStatus($merchantCode, $readerId)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/status', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Readers\StatusResponse::class);
    }

    /**
     * List Readers
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     *
     * @return array
     */
    public function list($merchantCode)
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * Terminate a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $body Optional request payload
     *
     * @return null
     */
    public function terminateCheckout($merchantCode, $readerId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/terminate', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '202' => ['type' => 'void'],
        ]);
    }

    /**
     * Update a Reader
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $id The unique identifier of the reader.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Readers\Reader
     */
    public function update($merchantCode, $id, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PATCH', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Readers\Reader::class);
    }
}
