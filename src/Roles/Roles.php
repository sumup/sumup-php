<?php

declare(strict_types=1);

namespace SumUp\Roles;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\HttpClient\RequestOptions;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class RolesListResponse
{
    /**
     *
     * @var \SumUp\Types\Role[]
     */
    public array $items;

}

class RolesCreateRequest
{
    /**
     * User-defined name of the role.
     *
     * @var string
     */
    public string $name;

    /**
     * User's permissions.
     *
     * @var string[]
     */
    public array $permissions;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array<string, mixed>|null
     */
    public ?array $metadata = null;

    /**
     * User-defined description of the role.
     *
     * @var string|null
     */
    public ?string $description = null;

}

class RolesUpdateRequest
{
    /**
     * User-defined name of the role.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * User's permissions.
     *
     * @var string[]|null
     */
    public ?array $permissions = null;

    /**
     * User-defined description of the role.
     *
     * @var string|null
     */
    public ?string $description = null;

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
    protected HttpClientInterface $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected string $accessToken;

    /**
     * Roles constructor.
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
     * Create a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param RolesCreateRequest|array<string, mixed> $body Required request payload
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Role
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function create(string $merchantCode, RolesCreateRequest|array $body, ?RequestOptions $requestOptions = null): \SumUp\Types\Role
    {
        $path = sprintf('/v0.1/merchants/%s/roles', rawurlencode((string) $merchantCode));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Role::class],
        ], [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'POST', $path);
    }

    /**
     * Delete a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return null
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function delete(string $merchantCode, string $roleId, ?RequestOptions $requestOptions = null): null
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'void'],
        ], [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'DELETE', $path);
    }

    /**
     * Retrieve a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Role
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function get(string $merchantCode, string $roleId, ?RequestOptions $requestOptions = null): \SumUp\Types\Role
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Role::class, [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * List roles
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Services\RolesListResponse
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function list(string $merchantCode, ?RequestOptions $requestOptions = null): \SumUp\Services\RolesListResponse
    {
        $path = sprintf('/v0.1/merchants/%s/roles', rawurlencode((string) $merchantCode));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Services\RolesListResponse::class, [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * Update a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     * @param RolesUpdateRequest|array<string, mixed> $body Required request payload
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Role
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function update(string $merchantCode, string $roleId, RolesUpdateRequest|array $body, ?RequestOptions $requestOptions = null): \SumUp\Types\Role
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PATCH', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Role::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'PATCH', $path);
    }
}
