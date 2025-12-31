<?php

declare(strict_types=1);

namespace SumUp\Roles;

/**
 * A custom role that can be used to assign set of permissions to members.
 */
class Role
{
    /**
     * Unique identifier of the role.
     *
     * @var string
     */
    public string $id;

    /**
     * User-defined name of the role.
     *
     * @var string
     */
    public string $name;

    /**
     * User-defined description of the role.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * List of permission granted by this role.
     *
     * @var string[]
     */
    public array $permissions;

    /**
     * True if the role is provided by SumUp.
     *
     * @var bool
     */
    public bool $isPredefined;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array|null
     */
    public ?array $metadata = null;

    /**
     * The timestamp of when the role was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the role was last updated.
     *
     * @var string
     */
    public string $updatedAt;

}


namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

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
     * Roles constructor.
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
     * Create a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Roles\Role
     */
    public function create($merchantCode, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/roles', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Roles\Role::class],
        ]);
    }

    /**
     * Delete a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     *
     * @return null
     */
    public function delete($merchantCode, $roleId)
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     *
     * @return \SumUp\Roles\Role
     */
    public function get($merchantCode, $roleId)
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Roles\Role::class);
    }

    /**
     * List roles
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     *
     * @return array
     */
    public function list($merchantCode)
    {
        $path = sprintf('/v0.1/merchants/%s/roles', rawurlencode((string) $merchantCode));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * Update a role
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $roleId The ID of the role to retrieve.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Roles\Role
     */
    public function update($merchantCode, $roleId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/roles/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $roleId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PATCH', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Roles\Role::class);
    }
}
