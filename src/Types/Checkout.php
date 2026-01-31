<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of the payment checkout.
 */
class Checkout
{
    /**
     * Unique ID of the payment checkout specified by the client application when creating the checkout resource.
     *
     * @var string|null
     */
    public ?string $checkoutReference = null;

    /**
     * Amount of the payment.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var CheckoutCurrency|null
     */
    public ?CheckoutCurrency $currency = null;

    /**
     * Unique identifying code of the merchant profile.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Short description of the checkout visible in the SumUp dashboard. The description can contribute to reporting, allowing easier identification of a checkout.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * URL to which the SumUp platform sends the processing status of the payment checkout.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * Unique ID of the checkout resource.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Current status of the checkout.
     *
     * @var CheckoutStatus|null
     */
    public ?CheckoutStatus $status = null;

    /**
     * Date and time of the creation of the payment checkout. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Date and time of the checkout expiration before which the client application needs to send a processing request. If no value is present, the checkout does not have an expiration time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * Unique identification of a customer. If specified, the checkout session and payment instrument are associated with the referenced customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Created mandate
     *
     * @var MandateResponse|null
     */
    public ?MandateResponse $mandate = null;

    /**
     * List of transactions related to the payment.
     *
     * @var mixed[]|null
     */
    public ?array $transactions = null;

}
