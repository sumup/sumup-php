<?php

declare(strict_types=1);

namespace SumUp\Transactions;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\HttpClient\RequestOptions;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

/**
 * Optional amount for partial refunds of transactions.
 */
class TransactionsRefundRequest
{
    /**
     * Amount to be refunded. Eligible amount can't exceed the amount of the transaction and varies based on country and currency. If you do not specify a value, the system performs a full refund of the transaction.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Create request DTO.
     *
     * @param float|null $amount
     */
    public function __construct(
        ?float $amount = null
    ) {
        \SumUp\Hydrator::hydrate([
            'amount' => $amount,
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

class TransactionsListDeprecatedResponse
{
    /**
     *
     * @var \SumUp\Types\TransactionHistory[]|null
     */
    public ?array $items = null;

    /**
     *
     * @var \SumUp\Types\TransactionsHistoryLink[]|null
     */
    public ?array $links = null;

}

class TransactionsListResponse
{
    /**
     *
     * @var \SumUp\Types\TransactionHistory[]|null
     */
    public ?array $items = null;

    /**
     *
     * @var \SumUp\Types\TransactionsHistoryLink[]|null
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
    public ?array $statusesList = null;

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
    public ?array $statusesList = null;

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
 * Transactions represent completed or attempted payment operations processed for a merchant account. A transaction contains the core payment result, such as the amount, currency, payment method, creation time, and current high-level status.
 *
 * In addition to the main payment outcome, a transaction can contain related events that describe what happened after the original payment attempt. These events provide visibility into the financial lifecycle of the transaction, for example:
 * - `PAYOUT`: the payment being prepared for payout or included in a payout to the merchant
 * - `REFUND`: money returned to the payer
 * - `CHARGE_BACK`: money reversed after the original payment
 * - `PAYOUT_DEDUCTION`: an amount deducted from a payout to cover a refund or chargeback
 *
 * From an integrator's perspective, transactions are the authoritative record of payment outcomes. Use this tag to:
 * - list transactions for reporting, reconciliation, and customer support workflows
 * - retrieve a single transaction when you need the latest payment details
 * - inspect `simple_status` for the current merchant-facing outcome of the payment
 * - inspect `events` or `transaction_events` when you need refund, payout, or chargeback history
 *
 * Typical workflow:
 * - create and process payments through the Checkouts endpoints
 * - use the Transactions endpoints to read the resulting payment records
 * - use the returned statuses and events to update your own order, accounting, or support systems
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
    protected HttpClientInterface $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected string $accessToken;

    /**
     * Transactions constructor.
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
     * Retrieve a transaction
     *
     * @param string $merchantCode Merchant code of the account whose transaction should be retrieved.
     * @param TransactionsGetParams|null $queryParams Optional query string parameters
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\TransactionFull
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function get(string $merchantCode, ?TransactionsGetParams $queryParams = null, ?RequestOptions $requestOptions = null): \SumUp\Types\TransactionFull
    {
        $path = sprintf('/v2.1/merchants/%s/transactions', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->id)) {
                $queryParamsData['id'] = $queryParams->id;
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

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\TransactionFull::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * Retrieve a transaction
     *
     * @param TransactionsGetDeprecatedParams|null $queryParams Optional query string parameters
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\TransactionFull
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function getDeprecated(?TransactionsGetDeprecatedParams $queryParams = null, ?RequestOptions $requestOptions = null): \SumUp\Types\TransactionFull
    {
        $path = '/v0.1/me/transactions';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->id)) {
                $queryParamsData['id'] = $queryParams->id;
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

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\TransactionFull::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * List transactions
     *
     * @param string $merchantCode Merchant code of the account whose transaction history should be listed.
     * @param TransactionsListParams|null $queryParams Optional query string parameters
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Services\TransactionsListResponse
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function list(string $merchantCode, ?TransactionsListParams $queryParams = null, ?RequestOptions $requestOptions = null): \SumUp\Services\TransactionsListResponse
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
            if (isset($queryParams->statusesList)) {
                $queryParamsData['statuses[]'] = $queryParams->statusesList;
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

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Services\TransactionsListResponse::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * List transactions
     *
     * @param TransactionsListDeprecatedParams|null $queryParams Optional query string parameters
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Services\TransactionsListDeprecatedResponse
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function listDeprecated(?TransactionsListDeprecatedParams $queryParams = null, ?RequestOptions $requestOptions = null): \SumUp\Services\TransactionsListDeprecatedResponse
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
            if (isset($queryParams->statusesList)) {
                $queryParamsData['statuses[]'] = $queryParams->statusesList;
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

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Services\TransactionsListDeprecatedResponse::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'GET', $path);
    }

    /**
     * Refund a transaction
     *
     * @param string $txnId Unique ID of the transaction.
     * @param TransactionsRefundRequest|array<string, mixed>|null $body Optional request payload
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return null
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function refund(string $txnId, TransactionsRefundRequest|array|null $body = null, ?RequestOptions $requestOptions = null): null
    {
        $path = sprintf('/v0.1/me/refund/%s', rawurlencode((string) $txnId));
        $payload = [];
        if ($body !== null) {
            $requestBody = $body;
            if (is_array($requestBody)) {
                $requestBody = TransactionsRefundRequest::fromArray($requestBody);
            }
            $payload = RequestEncoder::encode($requestBody);
        }
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, [
            '204' => ['type' => 'void'],
        ], [
            '404' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '409' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'POST', $path);
    }
}
