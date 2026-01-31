<?php

declare(strict_types=1);

namespace SumUp\Subaccounts;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

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
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function compatGetOperator($operatorId)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }

    /**
     * Create an operator
     *
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function createSubAccount($body = null)
    {
        $path = '/v0.1/me/accounts';
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }

    /**
     * Disable an operator.
     *
     * @param string $operatorId The unique identifier for the operator.
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function deactivateSubAccount($operatorId)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }

    /**
     * List operators
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\Operator[]
     *
     * @deprecated
     */
    public function listSubAccounts($queryParams = [])
    {
        $path = '/v0.1/me/accounts';
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Types\Operator::class]],
        ]);
    }

    /**
     * Update an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Types\Operator
     *
     * @deprecated
     */
    public function updateSubAccount($operatorId, $body = null)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Operator::class);
    }
}
