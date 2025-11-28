<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Merchants
 *
 * @package SumUp\Services
 */
class Merchants implements SumUpService
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
     * Merchants constructor.
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
     * Retrieve a Merchant
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Merchants\Merchant
     */
    public function get($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v1/merchants/%s', rawurlencode((string) $merchantCode));
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
            '200' => ['type' => 'class', 'class' => \SumUp\Merchants\Merchant::class],
        ]);
    }

    /**
     * Retrieve a Person
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $personId Person ID
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Merchants\Person
     */
    public function getPerson($merchantCode, $personId, $queryParams = [])
    {
        $path = sprintf('/v1/merchants/%s/persons/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $personId));
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
            '200' => ['type' => 'class', 'class' => \SumUp\Merchants\Person::class],
        ]);
    }

    /**
     * List Persons
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Merchants\ListPersonsResponseBody
     */
    public function listPersons($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v1/merchants/%s/persons', rawurlencode((string) $merchantCode));
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
            '200' => ['type' => 'class', 'class' => \SumUp\Merchants\ListPersonsResponseBody::class],
        ]);
    }
}
