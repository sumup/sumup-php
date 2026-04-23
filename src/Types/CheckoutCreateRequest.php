<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Request body for creating a checkout before processing payment. Define the payment amount, currency, merchant, and optional customer or redirect behavior here.
 */
class CheckoutCreateRequest
{
    /**
     * Merchant-defined reference for the new checkout. It should be unique enough for you to identify the payment attempt in your own systems.
     *
     * @var string
     */
    public string $checkoutReference;

    /**
     * Amount to be charged to the payer, expressed in major units.
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
     * Merchant account that should receive the payment.
     *
     * @var string
     */
    public string $merchantCode;

    /**
     * Short merchant-defined description shown in SumUp tools and reporting for easier identification of the checkout.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Optional backend callback URL used by SumUp to notify your platform about processing updates for the checkout.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * Merchant-scoped customer identifier. Required when setting up recurring payments and useful when the checkout should be linked to a returning payer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Business purpose of the checkout. Use `CHECKOUT` for a standard payment and `SETUP_RECURRING_PAYMENT` when collecting consent and payment details for future recurring charges.
     *
     * @var CheckoutCreateRequestPurpose|null
     */
    public ?CheckoutCreateRequestPurpose $purpose = null;

    /**
     * Optional expiration timestamp. The checkout must be processed before this moment, otherwise it becomes unusable. If omitted, the checkout does not have an explicit expiry time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * URL where the payer should be sent after a redirect-based payment or SCA flow completes. This is required for [APMs](https://developer.sumup.com/online-payments/apm/introduction) and recommended for card checkouts that may require [3DS](https://developer.sumup.com/online-payments/features/3ds). If it is omitted, the [Payment Widget](https://developer.sumup.com/online-payments/checkouts) can render the challenge in an iframe instead of using a full-page redirect.
     *
     * @var string|null
     */
    public ?string $redirectUrl = null;

    /**
     * Create request DTO.
     *
     * @param string $checkoutReference
     * @param float $amount
     * @param CheckoutCreateRequestCurrency|string $currency
     * @param string $merchantCode
     * @param string|null $description
     * @param string|null $returnUrl
     * @param string|null $customerId
     * @param CheckoutCreateRequestPurpose|string|null $purpose
     * @param string|null $validUntil
     * @param string|null $redirectUrl
     */
    public function __construct(
        string $checkoutReference,
        float $amount,
        CheckoutCreateRequestCurrency|string $currency,
        string $merchantCode,
        ?string $description = null,
        ?string $returnUrl = null,
        ?string $customerId = null,
        CheckoutCreateRequestPurpose|string|null $purpose = null,
        ?string $validUntil = null,
        ?string $redirectUrl = null
    ) {
        \SumUp\Hydrator::hydrate([
            'checkout_reference' => $checkoutReference,
            'amount' => $amount,
            'currency' => $currency,
            'merchant_code' => $merchantCode,
            'description' => $description,
            'return_url' => $returnUrl,
            'customer_id' => $customerId,
            'purpose' => $purpose,
            'valid_until' => $validUntil,
            'redirect_url' => $redirectUrl,
        ], self::class, $this);
    }

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        self::assertRequiredFields($data, [
            'checkout_reference' => 'checkoutReference',
            'amount' => 'amount',
            'currency' => 'currency',
            'merchant_code' => 'merchantCode',
        ]);

        $request = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        \SumUp\Hydrator::hydrate($data, self::class, $request);

        return $request;
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $requiredFields
     */
    private static function assertRequiredFields(array $data, array $requiredFields): void
    {
        foreach ($requiredFields as $serializedName => $propertyName) {
            if (!array_key_exists($serializedName, $data) && !array_key_exists($propertyName, $data)) {
                throw new \InvalidArgumentException(sprintf('Missing required field "%s".', $serializedName));
            }
        }
    }

}
