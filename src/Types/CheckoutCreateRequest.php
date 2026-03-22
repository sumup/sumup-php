<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of the payment checkout.
 */
class CheckoutCreateRequest
{
    /**
     * Unique ID of the payment checkout specified by the client application when creating the checkout resource.
     *
     * @var string
     */
    public string $checkoutReference;

    /**
     * Amount of the payment.
     *
     * @var float
     */
    public float $amount;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var CheckoutCreateRequestCurrency
     */
    public CheckoutCreateRequestCurrency $currency;

    /**
     * Unique identifying code of the merchant profile.
     *
     * @var string
     */
    public string $merchantCode;

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
     * Unique identification of a customer. If specified, the checkout session and payment instrument are associated with the referenced customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Purpose of the checkout.
     *
     * @var CheckoutCreateRequestPurpose|null
     */
    public ?CheckoutCreateRequestPurpose $purpose = null;

    /**
     * Date and time of the checkout expiration before which the client application needs to send a processing request. If no value is present, the checkout does not have an expiration time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * __Required__ for [APMs](https://developer.sumup.com/online-payments/apm/introduction) and __recommended__ for card payments. Refers to a url where the end user is redirected once the payment processing completes. If not specified, the [Payment Widget](https://developer.sumup.com/online-payments/tools/card-widget) renders [3DS challenge](https://developer.sumup.com/online-payments/features/3ds) within an iframe instead of performing a full-page redirect.
     *
     * @var string|null
     */
    public ?string $redirectUrl = null;

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if ($data !== []) {
            \SumUp\Hydrator::hydrate($data, self::class, $this);
        }
    }

}
