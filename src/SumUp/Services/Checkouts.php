<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

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
     * Checkouts constructor.
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
     * Create a checkout
     *
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Checkouts\Checkout
     */
    public function create($body = null)
    {
        $path = '/v0.1/checkouts';
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Checkouts\Checkout::class],
        ]);
    }

    /**
     * Deactivate a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\Checkouts\Checkout
     */
    public function deactivate($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Checkouts\Checkout::class],
        ]);
    }

    /**
     * Retrieve a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\Checkouts\CheckoutSuccess
     */
    public function get($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Checkouts\CheckoutSuccess::class],
        ]);
    }

    /**
     * List checkouts
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Checkouts\CheckoutSuccess[]
     */
    public function list($queryParams = [])
    {
        $path = '/v0.1/checkouts';
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Checkouts\CheckoutSuccess::class]],
        ]);
    }

    /**
     * Get available payment methods
     *
     * @param string $merchantCode The SumUp merchant code.
     * @param array $queryParams Optional query string parameters
     *
     * @return array
     */
    public function listAvailablePaymentMethods($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v0.1/merchants/%s/payment-methods', rawurlencode((string) $merchantCode));
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * Process a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Checkouts\CheckoutSuccess|\SumUp\Checkouts\CheckoutAccepted
     */
    public function process($id, $body = null)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Checkouts\CheckoutSuccess::class],
            '202' => ['type' => 'class', 'class' => \SumUp\Checkouts\CheckoutAccepted::class],
        ]);
    }
}
