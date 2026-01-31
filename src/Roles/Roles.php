<?php

declare(strict_types=1);

namespace SumUp\Roles;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class ListResponse
{
    /**
     *
     * @var \SumUp\Types\Role[]
     */
    public array $items;

}

/**
 * Class Roles
 *
 * @package SumUp\Services
 */
class Roles implements SumUpService
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
     * Roles constructor.
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
     * Create a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $body Optional request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Role
     */
    public function create($merchantCode, $body = null, $requestOptions = null)
    {
        $path = sprintf('/v0.1/merchants/%s/roles', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Role::class],
        ]);
    }

    /**
     * Delete a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return null
     */
    public function delete($merchantCode, $roleId, $requestOptions = null)
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Role
     */
    public function get($merchantCode, $roleId, $requestOptions = null)
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\Role::class);
    }

    /**
     * List roles
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Services\ListResponse
     */
    public function list($merchantCode, $requestOptions = null)
    {
        $path = sprintf('/v0.1/merchants/%s/roles', rawurlencode((string) $merchantCode));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Services\ListResponse::class);
    }

    /**
     * Update a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     * @param array|null $body Optional request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Role
     */
    public function update($merchantCode, $roleId, $body = null, $requestOptions = null)
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PATCH', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\Role::class);
    }
}
