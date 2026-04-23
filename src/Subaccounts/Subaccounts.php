<?php

declare(strict_types=1);

namespace SumUp\Subaccounts;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\HttpClient\RequestOptions;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

class SubaccountsCreateSubAccountRequest
{
    /**
     *
     * @var string
     */
    public string $username;

    /**
     *
     * @var string
     */
    public string $password;

    /**
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     *
     * @var SubaccountsCreateSubAccountRequestPermissions|null
     */
    public ?SubaccountsCreateSubAccountRequestPermissions $permissions = null;

    /**
     * Create request DTO.
     *
     * @param string $username
     * @param string $password
     * @param string|null $nickname
     * @param SubaccountsCreateSubAccountRequestPermissions|null $permissions
     */
    public function __construct(
        string $username,
        string $password,
        ?string $nickname = null,
        ?SubaccountsCreateSubAccountRequestPermissions $permissions = null
    ) {
        \SumUp\Hydrator::hydrate([
            'username' => $username,
            'password' => $password,
            'nickname' => $nickname,
            'permissions' => $permissions,
        ], self::class, $this);
    }

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        self::assertRequiredFields($data, [
            'username' => 'username',
            'password' => 'password',
        ]);

        $request = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        \SumUp\Hydrator::hydrate($data, self::class, $request);

        return $request;
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $requiredFields
     */
    private static function assertRequiredFields(array $data, array $requiredFields): void
    {
        foreach ($requiredFields as $serializedName => $propertyName) {
            if (!array_key_exists($serializedName, $data) && !array_key_exists($propertyName, $data)) {
                throw new \InvalidArgumentException(sprintf('Missing required field "%s".', $serializedName));
            }
        }
    }

}

class SubaccountsUpdateSubAccountRequest
{
    /**
     *
     * @var string|null
     */
    public ?string $password = null;

    /**
     *
     * @var string|null
     */
    public ?string $username = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $disabled = null;

    /**
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     *
     * @var SubaccountsUpdateSubAccountRequestPermissions|null
     */
    public ?SubaccountsUpdateSubAccountRequestPermissions $permissions = null;

    /**
     * Create request DTO.
     *
     * @param string|null $password
     * @param string|null $username
     * @param bool|null $disabled
     * @param string|null $nickname
     * @param SubaccountsUpdateSubAccountRequestPermissions|null $permissions
     */
    public function __construct(
        ?string $password = null,
        ?string $username = null,
        ?bool $disabled = null,
        ?string $nickname = null,
        ?SubaccountsUpdateSubAccountRequestPermissions $permissions = null
    ) {
        \SumUp\Hydrator::hydrate([
            'password' => $password,
            'username' => $username,
            'disabled' => $disabled,
            'nickname' => $nickname,
            'permissions' => $permissions,
        ], self::class, $this);
    }

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $request = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        \SumUp\Hydrator::hydrate($data, self::class, $request);

        return $request;
    }

}

class SubaccountsCreateSubAccountRequestPermissions
{
    /**
     *
     * @var bool|null
     */
    public ?bool $createMotoPayments = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $createReferral = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $fullTransactionHistoryView = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $refundTransactions = null;

}

class SubaccountsUpdateSubAccountRequestPermissions
{
    /**
     *
     * @var bool|null
     */
    public ?bool $createMotoPayments = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $createReferral = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $fullTransactionHistoryView = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $refundTransactions = null;

}

/**
 * Query parameters for SubaccountsListSubAccountsParams.
 *
 * @package SumUp\Services
 */
class SubaccountsListSubAccountsParams
{
    /**
     * Search query used to filter users that match given query term.
     * Current implementation allow querying only over the email address.
     * All operators whos email address contains the query string are returned.
     *
     * @var string|null
     */
    public ?string $query = null;

    /**
     * If true the list of operators will include also the primary user.
     *
     * @var bool|null
     */
    public ?bool $includePrimary = null;

}

/**
 * Class Subaccounts
 *
 * Endpoints for managing merchant sub-accounts (operators).
 *
 * @package SumUp\Services
 */
class Subaccounts implements SumUpService
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
     * Subaccounts constructor.
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
     * Retrieve an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Operator
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function compatGetOperator(string $operatorId, ?RequestOptions $requestOptions = null): \SumUp\Types\Operator
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Operator::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * Create an operator
     *
     * @param SubaccountsCreateSubAccountRequest|array<string, mixed> $body Required request payload
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Operator
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function createSubAccount(SubaccountsCreateSubAccountRequest|array $body, ?RequestOptions $requestOptions = null): \SumUp\Types\Operator
    {
        $path = '/v0.1/me/accounts';
        $payload = [];
        $requestBody = $body;
        if (is_array($requestBody)) {
            $requestBody = SubaccountsCreateSubAccountRequest::fromArray($requestBody);
        }
        $payload = RequestEncoder::encode($requestBody);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Operator::class, [
            '403' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'POST', $path);
    }

    /**
     * List operators
     *
     * @param SubaccountsListSubAccountsParams|null $queryParams Optional query string parameters
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Operator[]
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function listSubAccounts(?SubaccountsListSubAccountsParams $queryParams = null, ?RequestOptions $requestOptions = null): array
    {
        $path = '/v0.1/me/accounts';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->query)) {
                $queryParamsData['query'] = $queryParams->query;
            }
            if (isset($queryParams->includePrimary)) {
                $queryParamsData['include_primary'] = $queryParams->includePrimary;
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

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Types\Operator::class]],
        ], [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * Update an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param SubaccountsUpdateSubAccountRequest|array<string, mixed> $body Required request payload
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Operator
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function updateSubAccount(string $operatorId, SubaccountsUpdateSubAccountRequest|array $body, ?RequestOptions $requestOptions = null): \SumUp\Types\Operator
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $requestBody = $body;
        if (is_array($requestBody)) {
            $requestBody = SubaccountsUpdateSubAccountRequest::fromArray($requestBody);
        }
        $payload = RequestEncoder::encode($requestBody);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Operator::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'PUT', $path);
    }
}
