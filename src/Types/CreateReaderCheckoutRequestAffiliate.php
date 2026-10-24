<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * **SumUp API clients:** affiliate ingress for Reader Checkout.
 *
 * Send integrator metadata here when creating a checkout. When `app_id` and `key` are both
 * present, the key is validated against Identity Admin, stored server-side, and merged into
 * the payment when the reader starts the transaction using the returned `client_transaction_id`
 * as `terminal.client_id`.
 *
 * SDK clients send affiliate on `POST /api/terminals` instead.
 *
 */
class CreateReaderCheckoutRequestAffiliate
{
    /**
     * Integrator application identifier from the [Affiliate Keys](https://developer.sumup.com/affiliate-keys) page.
     * Required when the affiliate object is provided.
     *
     * @var string
     */
    public string $appId;

    /**
     * Integrator-owned transaction reference. Optional.
     * Forwarded to terminal-hub and can be used later to fetch the transaction via the [Transactions API](https://developer.sumup.com/api/transactions/get).
     *
     * @var string|null
     */
    public ?string $foreignTransactionId = null;

    /**
     * Affiliate key generated in the [Affiliate Keys](https://developer.sumup.com/affiliate-keys) page.
     * Required when the affiliate object is provided. Validated against Identity Admin when both `app_id` and `key` are present.
     *
     * @var string
     */
    public string $key;

    /**
     * Optional key-value metadata associated with the transaction.
     * Forwarded to terminal-hub together with the payment.
     *
     * @var array<string, mixed>|null
     */
    public ?array $tags = null;

}
