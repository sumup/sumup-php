<?php

declare(strict_types=1);

namespace SumUp\Types;

class TransactionHistory
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
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $transactionId = null;

    /**
     * Client-specific ID of the transaction.
     *
     * @var string|null
     */
    public ?string $clientTransactionId = null;

    /**
     * Email address of the registered user (merchant) to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $user = null;

    /**
     * Type of the transaction for the registered user specified in the `user` property.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * Issuing card network of the payment card used for the transaction.
     *
     * @var string|null
     */
    public ?string $cardType = null;

}
