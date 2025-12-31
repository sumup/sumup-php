<?php

declare(strict_types=1);

namespace SumUp\Receipts;

/**
 * Status of the transaction event.
 */
enum ReceiptEventStatus: string
{
    case PENDING = 'PENDING';
    case SCHEDULED = 'SCHEDULED';
    case FAILED = 'FAILED';
    case REFUNDED = 'REFUNDED';
    case SUCCESSFUL = 'SUCCESSFUL';
    case PAID_OUT = 'PAID_OUT';
}

/**
 * Type of the transaction event.
 */
enum ReceiptEventType: string
{
    case PAYOUT = 'PAYOUT';
    case CHARGE_BACK = 'CHARGE_BACK';
    case REFUND = 'REFUND';
    case PAYOUT_DEDUCTION = 'PAYOUT_DEDUCTION';
}

class Receipt
{
    /**
     * Transaction information.
     *
     * @var ReceiptTransaction|null
     */
    public ?ReceiptTransaction $transactionData = null;

    /**
     * Receipt merchant data
     *
     * @var ReceiptMerchantData|null
     */
    public ?ReceiptMerchantData $merchantData = null;

    /**
     *
     * @var array|null
     */
    public ?array $emvData = null;

    /**
     *
     * @var array|null
     */
    public ?array $acquirerData = null;

}

class ReceiptCard
{
    /**
     * Card last 4 digits.
     *
     * @var string|null
     */
    public ?string $last4Digits = null;

    /**
     * Card Scheme.
     *
     * @var string|null
     */
    public ?string $type = null;

}

class ReceiptEvent
{
    /**
     * Unique ID of the transaction event.
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $transactionId = null;

    /**
     * Type of the transaction event.
     *
     * @var ReceiptEventType|null
     */
    public ?ReceiptEventType $type = null;

    /**
     * Status of the transaction event.
     *
     * @var ReceiptEventStatus|null
     */
    public ?ReceiptEventStatus $status = null;

    /**
     * Amount of the event.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Date and time of the transaction event.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     *
     * @var string|null
     */
    public ?string $receiptNo = null;

}

/**
 * Receipt merchant data
 */
class ReceiptMerchantData
{
    /**
     *
     * @var array|null
     */
    public ?array $merchantProfile = null;

    /**
     *
     * @var string|null
     */
    public ?string $locale = null;

}

/**
 * Transaction information.
 */
class ReceiptTransaction
{
    /**
     * Transaction code.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Transaction amount.
     *
     * @var string|null
     */
    public ?string $amount = null;

    /**
     * Transaction VAT amount.
     *
     * @var string|null
     */
    public ?string $vatAmount = null;

    /**
     * Tip amount (included in transaction amount).
     *
     * @var string|null
     */
    public ?string $tipAmount = null;

    /**
     * Transaction currency.
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     * Time created at.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Transaction processing status.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Transaction type.
     *
     * @var string|null
     */
    public ?string $paymentType = null;

    /**
     * Transaction entry mode.
     *
     * @var string|null
     */
    public ?string $entryMode = null;

    /**
     * Cardholder verification method.
     *
     * @var string|null
     */
    public ?string $verificationMethod = null;

    /**
     *
     * @var ReceiptCard|null
     */
    public ?ReceiptCard $card = null;

    /**
     * Number of installments.
     *
     * @var int|null
     */
    public ?int $installmentsCount = null;

    /**
     * Products
     *
     * @var array[]|null
     */
    public ?array $products = null;

    /**
     * Vat rates.
     *
     * @var array[]|null
     */
    public ?array $vatRates = null;

    /**
     * Events
     *
     * @var ReceiptEvent[]|null
     */
    public ?array $events = null;

    /**
     * Receipt number
     *
     * @var string|null
     */
    public ?string $receiptNo = null;

}


namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Receipts
 *
 * @package SumUp\Services
 */
class Receipts implements SumUpService
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
     * Receipts constructor.
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
     * Retrieve receipt details
     *
     * @param string $id SumUp unique transaction ID or transaction code, e.g. TS7HDYLSKD.
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Receipts\Receipt
     */
    public function get($id, $queryParams = [])
    {
        $path = sprintf('/v1.1/receipts/%s', rawurlencode((string) $id));
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Receipts\Receipt::class);
    }
}
