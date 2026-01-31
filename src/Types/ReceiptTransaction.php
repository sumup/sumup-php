<?php

declare(strict_types=1);

namespace SumUp\Types;

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
