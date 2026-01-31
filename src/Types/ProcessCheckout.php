<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of the payment instrument for processing the checkout.
 */
class ProcessCheckout
{
    /**
     * Describes the payment method used to attempt processing
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
     * Mandate is passed when a card is to be tokenized
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
     * __Required when using a tokenized card to process a checkout.__ Unique token identifying the saved payment card for a customer.
     *
     * @var string|null
     */
    public ?string $token = null;

    /**
     * __Required when `token` is provided.__ Unique ID of the customer.
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
