<?php

declare(strict_types=1);

namespace SumUp\Types;

class TransactionFull
{
    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Transaction code returned by the acquirer/processing entity after processing the transaction.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Total amount of the transaction.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     * Date and time of the creation of the transaction. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Current status of the transaction.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Payment type used for the transaction.
     *
     * @var string|null
     */
    public ?string $paymentType = null;

    /**
     * Current number of the installment for deferred payments.
     *
     * @var int|null
     */
    public ?int $installmentsCount = null;

    /**
     * Unique code of the registered merchant to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Amount of the applicable VAT (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Amount of the tip (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $tipAmount = null;

    /**
     * Entry mode of the payment details.
     *
     * @var string|null
     */
    public ?string $entryMode = null;

    /**
     * Authorization code for the transaction sent by the payment card issuer or bank. Applicable only to card payments.
     *
     * @var string|null
     */
    public ?string $authCode = null;

    /**
     * Internal unique ID of the transaction on the SumUp platform.
     *
     * @var int|null
     */
    public ?int $internalId = null;

    /**
     * Short description of the payment. The value is taken from the `description` property of the related checkout resource.
     *
     * @var string|null
     */
    public ?string $productSummary = null;

    /**
     * Total number of payouts to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsTotal = null;

    /**
     * Number of payouts that are made to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsReceived = null;

    /**
     * Payout plan of the registered user at the time when the transaction was made.
     *
     * @var string|null
     */
    public ?string $payoutPlan = null;

    /**
     * Email address of the registered user (merchant) to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $username = null;

    /**
     * Latitude value from the coordinates of the payment location (as received from the payment terminal reader).
     *
     * @var float|null
     */
    public ?float $lat = null;

    /**
     * Longitude value from the coordinates of the payment location (as received from the payment terminal reader).
     *
     * @var float|null
     */
    public ?float $lon = null;

    /**
     * Indication of the precision of the geographical position received from the payment terminal.
     *
     * @var float|null
     */
    public ?float $horizontalAccuracy = null;

    /**
     * Simple name of the payment type.
     *
     * @var string|null
     */
    public ?string $simplePaymentType = null;

    /**
     * Verification method used for the transaction.
     *
     * @var string|null
     */
    public ?string $verificationMethod = null;

    /**
     * Details of the payment card.
     *
     * @var \SumUp\Transactions\CardResponse|null
     */
    public ?\SumUp\Transactions\CardResponse $card = null;

    /**
     * Local date and time of the creation of the transaction.
     *
     * @var string|null
     */
    public ?string $localTime = null;

    /**
     * Payout type for the transaction.
     *
     * @var string|null
     */
    public ?string $payoutType = null;

    /**
     * List of products from the merchant's catalogue for which the transaction serves as a payment.
     *
     * @var Product[]|null
     */
    public ?array $products = null;

    /**
     * List of VAT rates applicable to the transaction.
     *
     * @var mixed[]|null
     */
    public ?array $vatRates = null;

    /**
     * List of transaction events related to the transaction.
     *
     * @var TransactionEvent[]|null
     */
    public ?array $transactionEvents = null;

    /**
     * Status generated from the processing status and the latest transaction state.
     *
     * @var string|null
     */
    public ?string $simpleStatus = null;

    /**
     * List of hyperlinks for accessing related resources.
     *
     * @var mixed[]|null
     */
    public ?array $links = null;

    /**
     * List of events related to the transaction.
     *
     * @var Event[]|null
     */
    public ?array $events = null;

    /**
     * Details of the payment location as received from the payment terminal.
     *
     * @var array|null
     */
    public ?array $location = null;

    /**
     * Indicates whether tax deduction is enabled for the transaction.
     *
     * @var bool|null
     */
    public ?bool $taxEnabled = null;

}
