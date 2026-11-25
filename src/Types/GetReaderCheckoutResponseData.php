<?php

declare(strict_types=1);

namespace SumUp\Types;

class GetReaderCheckoutResponseData
{
    /**
     * Type of the card, or null when no card type was specified.
     *
     * @var GetReaderCheckoutResponseDataCardType|null
     */
    public ?GetReaderCheckoutResponseDataCardType $cardType;

    /**
     * Unique identifier for the checkout
     *
     * @var string
     */
    public string $checkoutId;

    /**
     * Client transaction identifier associated with the checkout
     *
     * @var string
     */
    public string $clientTransactionId;

    /**
     * Checkout creation timestamp
     *
     * @var string
     */
    public string $createdAt;

    /**
     * Number of installments for the transaction. Required for some countries.
     *
     * @var int|null
     */
    public ?int $installments;

    /**
     * Reason for the payment failure, or null when no failure reason is available.
     *
     * @var string|null
     */
    public ?string $paymentFailureReason;

    /**
     * Status of the payment, or null when no payment status is available.
     *
     * @var string|null
     */
    public ?string $paymentStatus;

    /**
     * Type of the payment. Required for some countries
     *
     * @var GetReaderCheckoutResponseDataPaymentType
     */
    public GetReaderCheckoutResponseDataPaymentType $paymentType;

    /**
     * Reader firmware version
     *
     * @var string
     */
    public string $readerFirmwareVersion;

    /**
     * Device serial number
     *
     * @var string
     */
    public string $readerSerialNumber;

    /**
     * Current status of the checkout
     *
     * @var GetReaderCheckoutResponseDataStatus
     */
    public GetReaderCheckoutResponseDataStatus $status;

    /**
     * The checkout amount. The value uses two decimal places, even for currencies
     * such as CLP that use zero decimal places in the create request.
     * For example, EUR 10.00 is returned as `1000` and CLP 1000 as `100000`.
     *
     * @var GetReaderCheckoutResponseDataTotalAmount
     */
    public GetReaderCheckoutResponseDataTotalAmount $totalAmount;

    /**
     * Checkout last update timestamp
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * Checkout expiration timestamp. After this time, the checkout will be automatically cancelled.
     *
     * @var string|null
     */
    public ?string $validUntil;

}
