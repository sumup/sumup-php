<?php

declare(strict_types=1);

namespace SumUp\Members;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class MembersListResponse
{
    /**
     *
     * @var \SumUp\Types\Member[]
     */
    public array $items;

    /**
     *
     * @var int|null
     */
    public ?int $totalCount = null;

}

class MembersCreateRequest
{
    /**
     * True if the user is managed by the merchant. In this case, we'll created a virtual user with the provided password and nickname.
     *
     * @var bool|null
     */
    public ?bool $isManagedUser = null;

    /**
     * Email address of the member to add.
     *
     * @var string
     */
    public string $email;

    /**
     * Password of the member to add. Only used if `is_managed_user` is true. In the case of service accounts, the password is not used and can not be defined by the caller.
     *
     * @var string|null
     */
    public ?string $password = null;

    /**
     * Nickname of the member to add. Only used if `is_managed_user` is true. Used for display purposes only.
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     * List of roles to assign to the new member.
     *
     * @var string[]
     */
    public array $roles;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array|null
     */
    public ?array $metadata = null;

    /**
     * Object attributes that are modifiable only by SumUp applications.
     *
     * @var array|null
     */
    public ?array $attributes = null;

}

class MembersUpdateRequest
{
    /**
     *
     * @var string[]|null
     */
    public ?array $roles = null;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata. Maximum of 64 parameters are allowed in the object.
     *
     * @var array|null
     */
    public ?array $metadata = null;

    /**
     * Object attributes that are modifiable only by SumUp applications.
     *
     * @var array|null
     */
    public ?array $attributes = null;

    /**
     * Allows you to update user data of managed users.
     *
     * @var array|null
     */
    public ?array $user = null;

}

/**
 * Query parameters for MembersListParams.
 *
 * @package SumUp\Services
 */
class MembersListParams
{
    /**
     * Offset of the first member to return.
     *
     * @var int|null
     */
    public ?int $offset = null;

    /**
     * Maximum number of members to return.
     *
     * @var int|null
     */
    public ?int $limit = null;

    /**
     * Indicates to skip count query.
     *
     * @var bool|null
     */
    public ?bool $scroll = null;

    /**
     * Filter the returned members by email address prefix.
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     * Search for a member by user id.
     *
     * @var string|null
     */
    public ?string $userId = null;

    /**
     * Filter the returned members by the membership status.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Filter the returned members by role.
     *
     * @var string[]|null
     */
    public ?array $roles = null;

}

/**
 * Class Members
 *
 * @package SumUp\Services
 */
class Members implements SumUpService
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
     * Members constructor.
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
     * Create a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param MembersCreateRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Member
     */
    public function create(string $merchantCode, MembersCreateRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Member
    {
        $path = sprintf('/v0.1/merchants/%s/members', rawurlencode((string) $merchantCode));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Member::class],
        ], [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '429' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'POST', $path);
    }

    /**
     * Delete a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return null
     */
    public function delete(string $merchantCode, string $memberId, ?array $requestOptions = null): null
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'void'],
        ], [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'DELETE', $path);
    }

    /**
     * Retrieve a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Member
     */
    public function get(string $merchantCode, string $memberId, ?array $requestOptions = null): \SumUp\Types\Member
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Member::class, [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * List members
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param MembersListParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Services\MembersListResponse
     */
    public function list(string $merchantCode, ?MembersListParams $queryParams = null, ?array $requestOptions = null): \SumUp\Services\MembersListResponse
    {
        $path = sprintf('/v0.1/merchants/%s/members', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->offset)) {
                $queryParamsData['offset'] = $queryParams->offset;
            }
            if (isset($queryParams->limit)) {
                $queryParamsData['limit'] = $queryParams->limit;
            }
            if (isset($queryParams->scroll)) {
                $queryParamsData['scroll'] = $queryParams->scroll;
            }
            if (isset($queryParams->email)) {
                $queryParamsData['email'] = $queryParams->email;
            }
            if (isset($queryParams->userId)) {
                $queryParamsData['user.id'] = $queryParams->userId;
            }
            if (isset($queryParams->status)) {
                $queryParamsData['status'] = $queryParams->status;
            }
            if (isset($queryParams->roles)) {
                $queryParamsData['roles'] = $queryParams->roles;
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

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Services\MembersListResponse::class, [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * Update a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     * @param MembersUpdateRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Member
     */
    public function update(string $merchantCode, string $memberId, MembersUpdateRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Member
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Member::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '409' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'PUT', $path);
    }
}
