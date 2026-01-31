<?php

declare(strict_types=1);

namespace SumUp\Subaccounts;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

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
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Subaccounts constructor.
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
     * Retrieve an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function compatGetOperator($operatorId, $requestOptions = null)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }

    /**
     * Create an operator
     *
     * @param array|null $body Optional request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function createSubAccount($body = null, $requestOptions = null)
    {
        $path = '/v0.1/me/accounts';
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }

    /**
     * Disable an operator.
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function deactivateSubAccount($operatorId, $requestOptions = null)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }

    /**
     * List operators
     *
     * @param SubaccountsListSubAccountsParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator[]
     *
     * @deprecated
     */
    public function listSubAccounts($queryParams = null, $requestOptions = null)
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

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Types\Operator::class]],
        ]);
    }

    /**
     * Update an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param array|null $body Optional request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function updateSubAccount($operatorId, $body = null, $requestOptions = null)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }
}
