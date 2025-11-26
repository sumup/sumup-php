<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;

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
     * @return \SumUp\HttpClients\Response
     */
    public function create($body = null)
    {
        $path = '/v0.1/checkouts';
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('POST', $path, $payload, $headers);
    }

    /**
     * Deactivate a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\HttpClients\Response
     */
    public function deactivate($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('DELETE', $path, $payload, $headers);
    }

    /**
     * Retrieve a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     *
     * @return \SumUp\HttpClients\Response
     */
    public function get($id)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * List checkouts
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\HttpClients\Response
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

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * Get available payment methods
     *
     * @param string $merchantCode The SumUp merchant code.
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\HttpClients\Response
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

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * Process a checkout
     *
     * @param string $id Unique ID of the checkout resource.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\HttpClients\Response
     */
    public function process($id, $body = null)
    {
        $path = sprintf('/v0.1/checkouts/%s', rawurlencode((string) $id));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('PUT', $path, $payload, $headers);
    }
}
