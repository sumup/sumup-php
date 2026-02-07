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

class ListDeprecatedResponse
{
    /**
     *
     * @var \SumUp\Types\TransactionHistory[]|null
     */
    public ?array $items = null;

    /**
     *
     * @var \SumUp\Types\Link[]|null
     */
    public ?array $links = null;

}

class ListResponse
{
    /**
     *
     * @var \SumUp\Types\TransactionHistory[]|null
     */
    public ?array $items = null;

    /**
     *
     * @var \SumUp\Types\Link[]|null
     */
    public ?array $links = null;

}

/**
 * Query parameters for TransactionsGetParams.
 *
 * @package SumUp\Services
 */
class TransactionsGetParams
{
    /**
     * Retrieves the transaction resource with the specified transaction ID (the `id` parameter in the transaction resource).
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Retrieves the transaction resource with the specified internal transaction ID (the `internal_id` parameter in the transaction resource).
     *
     * @var string|null
     */
    public ?string $internalId = null;

    /**
     * Retrieves the transaction resource with the specified transaction code.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * External/foreign transaction id (passed by clients).
     *
     * @var string|null
     */
    public ?string $foreignTransactionId = null;

    /**
     * Client transaction id.
     *
     * @var string|null
     */
    public ?string $clientTransactionId = null;

}

/**
 * Query parameters for TransactionsGetDeprecatedParams.
 *
 * @package SumUp\Services
 */
class TransactionsGetDeprecatedParams
{
    /**
     * Retrieves the transaction resource with the specified transaction ID (the `id` parameter in the transaction resource).
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Retrieves the transaction resource with the specified internal transaction ID (the `internal_id` parameter in the transaction resource).
     *
     * @var string|null
     */
    public ?string $internalId = null;

    /**
     * Retrieves the transaction resource with the specified transaction code.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

}

/**
 * Query parameters for TransactionsListParams.
 *
 * @package SumUp\Services
 */
class TransactionsListParams
{
    /**
     * Retrieves the transaction resource with the specified transaction code.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Specifies the order in which the returned results are displayed.
     *
     * @var string|null
     */
    public ?string $order = null;

    /**
     * Specifies the maximum number of results per page. Value must be a positive integer and if not specified, will return 10 results.
     *
     * @var int|null
     */
    public ?int $limit = null;

    /**
     * Filters the returned results by user email.
     *
     * @var string[]|null
     */
    public ?array $users = null;

    /**
     * Filters the returned results by the specified list of final statuses of the transactions.
     *
     * @var string[]|null
     */
    public ?array $statuses = null;

    /**
     * Filters the returned results by the specified list of payment types used for the transactions.
     *
     * @var string[]|null
     */
    public ?array $paymentTypes = null;

    /**
     * Filters the returned results by the specified list of entry modes.
     *
     * @var string[]|null
     */
    public ?array $entryModesList = null;

    /**
     * Filters the returned results by the specified list of transaction types.
     *
     * @var string[]|null
     */
    public ?array $types = null;

    /**
     * Filters the results by the latest modification time of resources and returns only transactions that are modified *at or after* the specified timestamp (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string|null
     */
    public ?string $changesSince = null;

    /**
     * Filters the results by the creation time of resources and returns only transactions that are created *before* the specified timestamp (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string|null
     */
    public ?string $newestTime = null;

    /**
     * Filters the results by the reference ID of transaction events and returns only transactions with events whose IDs are *smaller* than the specified value. This parameters supersedes the `newest_time` parameter (if both are provided in the request).
     *
     * @var string|null
     */
    public ?string $newestRef = null;

    /**
     * Filters the results by the creation time of resources and returns only transactions that are created *at or after* the specified timestamp (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string|null
     */
    public ?string $oldestTime = null;

    /**
     * Filters the results by the reference ID of transaction events and returns only transactions with events whose IDs are *greater* than the specified value. This parameters supersedes the `oldest_time` parameter (if both are provided in the request).
     *
     * @var string|null
     */
    public ?string $oldestRef = null;

}

/**
 * Query parameters for TransactionsListDeprecatedParams.
 *
 * @package SumUp\Services
 */
class TransactionsListDeprecatedParams
{
    /**
     * Retrieves the transaction resource with the specified transaction code.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Specifies the order in which the returned results are displayed.
     *
     * @var string|null
     */
    public ?string $order = null;

    /**
     * Specifies the maximum number of results per page. Value must be a positive integer and if not specified, will return 10 results.
     *
     * @var int|null
     */
    public ?int $limit = null;

    /**
     * Filters the returned results by user email.
     *
     * @var string[]|null
     */
    public ?array $users = null;

    /**
     * Filters the returned results by the specified list of final statuses of the transactions.
     *
     * @var string[]|null
     */
    public ?array $statuses = null;

    /**
     * Filters the returned results by the specified list of payment types used for the transactions.
     *
     * @var string[]|null
     */
    public ?array $paymentTypes = null;

    /**
     * Filters the returned results by the specified list of transaction types.
     *
     * @var string[]|null
     */
    public ?array $types = null;

    /**
     * Filters the results by the latest modification time of resources and returns only transactions that are modified *at or after* the specified timestamp (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string|null
     */
    public ?string $changesSince = null;

    /**
     * Filters the results by the creation time of resources and returns only transactions that are created *before* the specified timestamp (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string|null
     */
    public ?string $newestTime = null;

    /**
     * Filters the results by the reference ID of transaction events and returns only transactions with events whose IDs are *smaller* than the specified value. This parameters supersedes the `newest_time` parameter (if both are provided in the request).
     *
     * @var string|null
     */
    public ?string $newestRef = null;

    /**
     * Filters the results by the creation time of resources and returns only transactions that are created *at or after* the specified timestamp (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string|null
     */
    public ?string $oldestTime = null;

    /**
     * Filters the results by the reference ID of transaction events and returns only transactions with events whose IDs are *greater* than the specified value. This parameters supersedes the `oldest_time` parameter (if both are provided in the request).
     *
     * @var string|null
     */
    public ?string $oldestRef = null;

}

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
     * @param TransactionsGetParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\TransactionFull
     */
    public function get($merchantCode, $queryParams = null, $requestOptions = null)
    {
        $path = sprintf('/v2.1/merchants/%s/transactions', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->id)) {
                $queryParamsData['id'] = $queryParams->id;
            }
            if (isset($queryParams->internalId)) {
                $queryParamsData['internal_id'] = $queryParams->internalId;
            }
            if (isset($queryParams->transactionCode)) {
                $queryParamsData['transaction_code'] = $queryParams->transactionCode;
            }
            if (isset($queryParams->foreignTransactionId)) {
                $queryParamsData['foreign_transaction_id'] = $queryParams->foreignTransactionId;
            }
            if (isset($queryParams->clientTransactionId)) {
                $queryParamsData['client_transaction_id'] = $queryParams->clientTransactionId;
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

        return ResponseDecoder::decode($response, \SumUp\Types\TransactionFull::class);
    }

    /**
     * Retrieve a transaction
     *
     * @param TransactionsGetDeprecatedParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\TransactionFull
     *
     * @deprecated
     */
    public function getDeprecated($queryParams = null, $requestOptions = null)
    {
        $path = '/v0.1/me/transactions';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->id)) {
                $queryParamsData['id'] = $queryParams->id;
            }
            if (isset($queryParams->internalId)) {
                $queryParamsData['internal_id'] = $queryParams->internalId;
            }
            if (isset($queryParams->transactionCode)) {
                $queryParamsData['transaction_code'] = $queryParams->transactionCode;
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

        return ResponseDecoder::decode($response, \SumUp\Types\TransactionFull::class);
    }

    /**
     * List transactions
     *
     * @param string $merchantCode
     * @param TransactionsListParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Services\ListResponse
     */
    public function list($merchantCode, $queryParams = null, $requestOptions = null)
    {
        $path = sprintf('/v2.1/merchants/%s/transactions/history', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->transactionCode)) {
                $queryParamsData['transaction_code'] = $queryParams->transactionCode;
            }
            if (isset($queryParams->order)) {
                $queryParamsData['order'] = $queryParams->order;
            }
            if (isset($queryParams->limit)) {
                $queryParamsData['limit'] = $queryParams->limit;
            }
            if (isset($queryParams->users)) {
                $queryParamsData['users'] = $queryParams->users;
            }
            if (isset($queryParams->statuses)) {
                $queryParamsData['statuses'] = $queryParams->statuses;
            }
            if (isset($queryParams->paymentTypes)) {
                $queryParamsData['payment_types'] = $queryParams->paymentTypes;
            }
            if (isset($queryParams->entryModesList)) {
                $queryParamsData['entry_modes[]'] = $queryParams->entryModesList;
            }
            if (isset($queryParams->types)) {
                $queryParamsData['types'] = $queryParams->types;
            }
            if (isset($queryParams->changesSince)) {
                $queryParamsData['changes_since'] = $queryParams->changesSince;
            }
            if (isset($queryParams->newestTime)) {
                $queryParamsData['newest_time'] = $queryParams->newestTime;
            }
            if (isset($queryParams->newestRef)) {
                $queryParamsData['newest_ref'] = $queryParams->newestRef;
            }
            if (isset($queryParams->oldestTime)) {
                $queryParamsData['oldest_time'] = $queryParams->oldestTime;
            }
            if (isset($queryParams->oldestRef)) {
                $queryParamsData['oldest_ref'] = $queryParams->oldestRef;
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

    /**
     * List transactions
     *
     * @param TransactionsListDeprecatedParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Services\ListDeprecatedResponse
     *
     * @deprecated
     */
    public function listDeprecated($queryParams = null, $requestOptions = null)
    {
        $path = '/v0.1/me/transactions/history';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->transactionCode)) {
                $queryParamsData['transaction_code'] = $queryParams->transactionCode;
            }
            if (isset($queryParams->order)) {
                $queryParamsData['order'] = $queryParams->order;
            }
            if (isset($queryParams->limit)) {
                $queryParamsData['limit'] = $queryParams->limit;
            }
            if (isset($queryParams->users)) {
                $queryParamsData['users'] = $queryParams->users;
            }
            if (isset($queryParams->statuses)) {
                $queryParamsData['statuses'] = $queryParams->statuses;
            }
            if (isset($queryParams->paymentTypes)) {
                $queryParamsData['payment_types'] = $queryParams->paymentTypes;
            }
            if (isset($queryParams->types)) {
                $queryParamsData['types'] = $queryParams->types;
            }
            if (isset($queryParams->changesSince)) {
                $queryParamsData['changes_since'] = $queryParams->changesSince;
            }
            if (isset($queryParams->newestTime)) {
                $queryParamsData['newest_time'] = $queryParams->newestTime;
            }
            if (isset($queryParams->newestRef)) {
                $queryParamsData['newest_ref'] = $queryParams->newestRef;
            }
            if (isset($queryParams->oldestTime)) {
                $queryParamsData['oldest_time'] = $queryParams->oldestTime;
            }
            if (isset($queryParams->oldestRef)) {
                $queryParamsData['oldest_ref'] = $queryParams->oldestRef;
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

        return ResponseDecoder::decode($response, \SumUp\Services\ListDeprecatedResponse::class);
    }

    /**
     * Refund a transaction
     *
     * @param string $txnId Unique ID of the transaction.
     * @param array|null $body Optional request payload
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return null
     */
    public function refund($txnId, $body = null, $requestOptions = null)
    {
        $path = sprintf('/v0.1/me/refund/%s', rawurlencode((string) $txnId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, [
            '204' => ['type' => 'void'],
        ]);
    }
}
