<?php

declare(strict_types=1);

namespace SumUp\Memberships;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class ListResponse
{
    /**
     *
     * @var \SumUp\Types\Membership[]
     */
    public array $items;

    /**
     *
     * @var int
     */
    public int $totalCount;

}

/**
 * Query parameters for MembershipsListParams.
 *
 * @package SumUp\Services
 */
class MembershipsListParams
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
     * Filter memberships by resource kind.
     *
     * @var string|null
     */
    public ?string $kind = null;

    /**
     * Filter the returned memberships by the membership status.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Filter memberships by resource kind.
     *
     * @var string|null
     */
    public ?string $resourceType = null;

    /**
     * Filter memberships by the sandbox status of the resource the membership is in.
     *
     * @var bool|null
     */
    public ?bool $resourceAttributesSandbox = null;

    /**
     * Filter memberships by the name of the resource the membership is in.
     *
     * @var string|null
     */
    public ?string $resourceName = null;

    /**
     * Filter memberships by the parent of the resource the membership is in.
     * When filtering by parent both `resource.parent.id` and `resource.parent.type` must be present. Pass explicit null to filter for resources without a parent.
     *
     * @var string|null
     */
    public ?string $resourceParentId = null;

    /**
     * Filter memberships by the parent of the resource the membership is in.
     * When filtering by parent both `resource.parent.id` and `resource.parent.type` must be present. Pass explicit null to filter for resources without a parent.
     *
     * @var mixed|null
     */
    public mixed $resourceParentType = null;

    /**
     * Filter the returned memberships by role.
     *
     * @var string[]|null
     */
    public ?array $roles = null;

}

/**
 * Class Memberships
 *
 * @package SumUp\Services
 */
class Memberships implements SumUpService
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
     * Memberships constructor.
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
     * List memberships
     *
     * @param MembershipsListParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Services\ListResponse
     */
    public function list($queryParams = null, $requestOptions = null)
    {
        $path = '/v0.1/memberships';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->offset)) {
                $queryParamsData['offset'] = $queryParams->offset;
            }
            if (isset($queryParams->limit)) {
                $queryParamsData['limit'] = $queryParams->limit;
            }
            if (isset($queryParams->kind)) {
                $queryParamsData['kind'] = $queryParams->kind;
            }
            if (isset($queryParams->status)) {
                $queryParamsData['status'] = $queryParams->status;
            }
            if (isset($queryParams->resourceType)) {
                $queryParamsData['resource.type'] = $queryParams->resourceType;
            }
            if (isset($queryParams->resourceAttributesSandbox)) {
                $queryParamsData['resource.attributes.sandbox'] = $queryParams->resourceAttributesSandbox;
            }
            if (isset($queryParams->resourceName)) {
                $queryParamsData['resource.name'] = $queryParams->resourceName;
            }
            if (isset($queryParams->resourceParentId)) {
                $queryParamsData['resource.parent.id'] = $queryParams->resourceParentId;
            }
            if (isset($queryParams->resourceParentType)) {
                $queryParamsData['resource.parent.type'] = $queryParams->resourceParentType;
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

        return ResponseDecoder::decode($response, \SumUp\Services\ListResponse::class);
    }
}
