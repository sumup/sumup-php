<?php

declare(strict_types=1);

namespace SumUp\Transactions;

/**
 * Details of the payment card.
 */
class CardResponse
{
    /**
     * Last 4 digits of the payment card number.
     *
     * @var string|null
     */
    public ?string $last4Digits = null;

    /**
     * Issuing card network of the payment card used for the transaction.
     *
     * @var \SumUp\Types\CardResponseType|null
     */
    public ?\SumUp\Types\CardResponseType $type = null;

}

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

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
     * Transactions constructor.
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
     * Retrieve a transaction
     *
     * @param string $merchantCode
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\TransactionFull
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
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\TransactionFull::class);
    }

    /**
     * Retrieve a transaction
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\TransactionFull
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
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\TransactionFull::class);
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
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

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
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

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
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '204' => ['type' => 'void'],
        ]);
    }
}
