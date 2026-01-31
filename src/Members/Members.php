<?php

declare(strict_types=1);

namespace SumUp\Members;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class ListResponse
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
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Members constructor.
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
     * Create a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Types\Member
     */
    public function create($merchantCode, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/members', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Types\Member::class],
        ]);
    }

    /**
     * Delete a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     *
     * @return null
     */
    public function delete($merchantCode, $memberId)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     *
     * @return \SumUp\Types\Member
     */
    public function get($merchantCode, $memberId)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Member::class);
    }

    /**
     * List members
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param MembersListParams|null $queryParams Optional query string parameters
     *
     * @return \SumUp\Services\ListResponse
     */
    public function list($merchantCode, $queryParams = null)
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

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Services\ListResponse::class);
    }

    /**
     * Update a member
     *
     * @param string $merchantCode Short unique identifier for the merchant.
     * @param string $memberId The ID of the member to retrieve.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Types\Member
     */
    public function update($merchantCode, $memberId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Member::class);
    }
}
