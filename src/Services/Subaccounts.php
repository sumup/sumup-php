<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

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
     * Subaccounts constructor.
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
     * Retrieve an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     *
     * @return \SumUp\Subaccounts\Operator
     *
     * @deprecated
     */
    public function compatGetOperator($operatorId)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Subaccounts\Operator::class);
    }

    /**
     * Create an operator
     *
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Subaccounts\Operator
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
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Subaccounts\Operator::class);
    }

    /**
     * Disable an operator.
     *
     * @param string $operatorId The unique identifier for the operator.
     *
     * @return \SumUp\Subaccounts\Operator
     *
     * @deprecated
     */
    public function deactivateSubAccount($operatorId)
    {
        $path = sprintf('/v0.1/me/accounts/%s', rawurlencode((string) $operatorId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Subaccounts\Operator::class);
    }

    /**
     * List operators
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Subaccounts\Operator[]
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
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'class', 'class' => \SumUp\Subaccounts\Operator::class]],
        ]);
    }

    /**
     * Update an operator
     *
     * @param string $operatorId The unique identifier for the operator.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Subaccounts\Operator
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
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Subaccounts\Operator::class);
    }
}
