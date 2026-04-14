<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Request body for attempting payment on an existing checkout. The required companion fields depend on the selected `payment_type`, for example card details, saved-card data, or payer information required by a specific payment method.
 */
class ProcessCheckout
{
    /**
     * Payment method used for this processing attempt. It determines which additional request fields are required.
     *
     * @var ProcessCheckoutPaymentType
     */
    public ProcessCheckoutPaymentType $paymentType;

    /**
     * Number of installments for deferred payments. Available only to merchant users in Brazil.
     *
     * @var int|null
     */
    public ?int $installments = null;

    /**
     * Mandate details used when a checkout should create a reusable card token for future recurring or merchant-initiated payments.
     *
     * @var MandatePayload|null
     */
    public ?MandatePayload $mandate = null;

    /**
     * __Required when payment type is `card`.__ Details of the payment card.
     *
     * @var Card|null
     */
    public ?Card $card = null;

    /**
     * Raw `PaymentData` object received from Google Pay. Send the Google Pay response payload as-is.
     *
     * @var ProcessCheckoutGooglePay|null
     */
    public ?ProcessCheckoutGooglePay $googlePay = null;

    /**
     * Raw payment token object received from Apple Pay. Send the Apple Pay response payload as-is.
     *
     * @var ProcessCheckoutApplePay|null
     */
    public ?ProcessCheckoutApplePay $applePay = null;

    /**
     * Saved-card token to use instead of raw card details when processing with a previously stored payment instrument.
     *
     * @var string|null
     */
    public ?string $token = null;

    /**
     * Customer identifier associated with the saved payment instrument. Required when `token` is provided.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Personal details for the customer.
     *
     * @var PersonalDetails|null
     */
    public ?PersonalDetails $personalDetails = null;

}
