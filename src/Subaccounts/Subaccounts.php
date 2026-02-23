<?php

declare(strict_types=1);

namespace SumUp\Subaccounts;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
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
     * @var array|null
     */
    public ?array $permissions = null;

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
     * @var array|null
     */
    public ?array $permissions = null;

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
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function compatGetOperator(string $operatorId, ?array $requestOptions = null): \SumUp\Types\Operator
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Operator::class, null, 'GET', $path);
    }

    /**
     * Create an operator
     *
     * @param SubaccountsCreateSubAccountRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function createSubAccount(SubaccountsCreateSubAccountRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Operator
    {
        $path = '/v0.1/me/accounts';
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Operator::class, [
            '403' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'POST', $path);
    }

    /**
     * Disable an operator.
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function deactivateSubAccount(string $operatorId, ?array $requestOptions = null): \SumUp\Types\Operator
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Operator::class, null, 'DELETE', $path);
    }

    /**
     * List operators
     *
     * @param SubaccountsListSubAccountsParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator[]
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function listSubAccounts(?SubaccountsListSubAccountsParams $queryParams = null, ?array $requestOptions = null): array
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
        ], null, 'GET', $path);
    }

    /**
     * Update an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param SubaccountsUpdateSubAccountRequest|array $body Required request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function updateSubAccount(string $operatorId, SubaccountsUpdateSubAccountRequest|array $body, ?array $requestOptions = null): \SumUp\Types\Operator
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $payload = RequestEncoder::encode($body);
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Operator::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'PUT', $path);
    }
}
