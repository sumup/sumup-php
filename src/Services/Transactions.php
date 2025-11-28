<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Transactions
 *
 * @package SumUp\Services
 */
class Transactions implements SumUpService
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
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * Transactions constructor.
     *
     * @param SumUpHttpClientInterface $client
     * @param AccessToken $accessToken
     */
    public function __construct(SumUpHttpClientInterface $client, AccessToken $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Retrieve a transaction
     *
     * @param string $merchantCode
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Transactions\TransactionFull
     */
    public function get($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v2.1/merchants/%s/transactions', rawurlencode((string) $merchantCode));
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
            '200' => ['type' => 'class', 'class' => \SumUp\Transactions\TransactionFull::class],
        ]);
    }

    /**
     * Retrieve a transaction
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Transactions\TransactionFull
     *
     * @deprecated
     */
    public function getDeprecated($queryParams = [])
    {
        $path = '/v0.1/me/transactions';
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
            '200' => ['type' => 'class', 'class' => \SumUp\Transactions\TransactionFull::class],
        ]);
    }

    /**
     * List transactions
     *
     * @param string $merchantCode
     * @param array $queryParams Optional query string parameters
     *
     * @return array
     */
    public function list($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v2.1/merchants/%s/transactions/history', rawurlencode((string) $merchantCode));
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
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * List transactions
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return array
     *
     * @deprecated
     */
    public function listDeprecated($queryParams = [])
    {
        $path = '/v0.1/me/transactions/history';
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
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * Refund a transaction
     *
     * @param string $txnId Unique ID of the transaction.
     * @param array|null $body Optional request payload
     *
     * @return null
     */
    public function refund($txnId, $body = null)
    {
        $path = sprintf('/v0.1/me/refund/%s', rawurlencode((string) $txnId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '204' => ['type' => 'void'],
        ]);
    }
}
