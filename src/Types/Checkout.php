<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Core checkout resource returned by the Checkouts API. A checkout is created before payment processing and then updated as payment attempts, redirects, and resulting transactions are attached to it.
 */
class Checkout
{
    /**
     * Merchant-defined reference for the checkout. Use it to correlate the SumUp checkout with your own order, cart, subscription, or payment attempt in your systems.
     *
     * @var string|null
     */
    public ?string $checkoutReference = null;

    /**
     * Amount to be charged to the payer, expressed in major units.
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
     * Merchant account that receives the payment.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Short merchant-defined description shown in SumUp tools and reporting. Use it to make the checkout easier to recognize in dashboards, support workflows, and reconciliation.
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
     * Unique SumUp identifier of the checkout resource.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Current high-level state of the checkout. `PENDING` means the checkout exists but is not yet completed, `PAID` means a payment succeeded, `FAILED` means the latest processing attempt failed, and `EXPIRED` means the checkout can no longer be processed.
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
     * Optional expiration timestamp. The checkout must be processed before this moment, otherwise it becomes unusable. If omitted, the checkout does not have an explicit expiry time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * Merchant-scoped identifier of the customer associated with the checkout. Use it when storing payment instruments or reusing saved customer context for recurring and returning-payer flows.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Details of the mandate linked to the saved payment instrument.
     *
     * @var MandateResponse|null
     */
    public ?MandateResponse $mandate = null;

    /**
     * Payment attempts and resulting transaction records linked to this checkout. Use the Transactions endpoints when you need the authoritative payment result and event history.
     *
     * @var mixed[]|null
     */
    public ?array $transactions = null;

}
