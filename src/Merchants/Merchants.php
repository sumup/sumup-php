<?php

declare(strict_types=1);

namespace SumUp\Merchants;

class ListPersonsResponseBody
{
    /**
     *
     * @var \SumUp\Types\Person[]
     */
    public array $items;

}

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

/**
 * Query parameters for MerchantsGetParams.
 *
 * @package SumUp\Services
 */
class MerchantsGetParams
{
    /**
     * The version of the resource. At the moment, the only supported value is `latest`. When provided and the requested resource's `change_status` is pending, the resource will be returned with all pending changes applied. When no changes are pending the resource is returned as is. The `change_status` in the response body will reflect the current state of the resource.
     *
     * @var string|null
     */
    public ?string $version = null;

}

/**
 * Query parameters for MerchantsGetPersonParams.
 *
 * @package SumUp\Services
 */
class MerchantsGetPersonParams
{
    /**
     * The version of the resource. At the moment, the only supported value is `latest`. When provided and the requested resource's `change_status` is pending, the resource will be returned with all pending changes applied. When no changes are pending the resource is returned as is. The `change_status` in the response body will reflect the current state of the resource.
     *
     * @var string|null
     */
    public ?string $version = null;

}

/**
 * Query parameters for MerchantsListPersonsParams.
 *
 * @package SumUp\Services
 */
class MerchantsListPersonsParams
{
    /**
     * The version of the resource. At the moment, the only supported value is `latest`. When provided and the requested resource's `change_status` is pending, the resource will be returned with all pending changes applied. When no changes are pending the resource is returned as is. The `change_status` in the response body will reflect the current state of the resource.
     *
     * @var string|null
     */
    public ?string $version = null;

}

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
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Merchants constructor.
     *
     * @param HttpClientInterface $client
     * @param $accessToken
     */
    public function __construct(HttpClientInterface $client, $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Retrieve a Merchant
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param MerchantsGetParams|null $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\Merchant
     */
    public function get($merchantCode, $queryParams = null)
    {
        $path = sprintf('/v1/merchants/%s', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->version)) {
                $queryParamsData['version'] = $queryParams->version;
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

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Merchant::class);
    }

    /**
     * Retrieve a Person
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $personId Person ID
     * @param MerchantsGetPersonParams|null $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\Person
     */
    public function getPerson($merchantCode, $personId, $queryParams = null)
    {
        $path = sprintf('/v1/merchants/%s/persons/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $personId));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->version)) {
                $queryParamsData['version'] = $queryParams->version;
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

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Person::class);
    }

    /**
     * List Persons
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param MerchantsListPersonsParams|null $queryParams Optional query string parameters
     *
     * @return \SumUp\Merchants\ListPersonsResponseBody
     */
    public function listPersons($merchantCode, $queryParams = null)
    {
        $path = sprintf('/v1/merchants/%s/persons', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->version)) {
                $queryParamsData['version'] = $queryParams->version;
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

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Merchants\ListPersonsResponseBody::class);
    }
}
