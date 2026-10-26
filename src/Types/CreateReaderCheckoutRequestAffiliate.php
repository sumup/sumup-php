<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Optional affiliate metadata associated with the checkout's payment.
 * Provide both `app_id` and `key` when including this object.
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
     * Can be used to retrieve the transaction via the [Transactions API](https://developer.sumup.com/api/transactions/get).
     *
     * @var string|null
     */
    public ?string $foreignTransactionId = null;

    /**
     * Affiliate key generated in the [Affiliate Keys](https://developer.sumup.com/affiliate-keys) page.
     * Required when the affiliate object is provided.
     *
     * @var string
     */
    public string $key;

    /**
     * Optional key-value metadata associated with the transaction.
     *
     * @var array<string, mixed>|null
     */
    public ?array $tags = null;

}
