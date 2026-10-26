<?php

declare(strict_types=1);

namespace SumUp\Types;

class CreateReaderCheckoutResponseData
{
    /**
     * The checkout ID is a unique identifier for the checkout.
     *
     * @var string|null
     */
    public ?string $checkoutId = null;

    /**
     * Unique identifier for the transaction associated with this checkout.
     * Use this value to match the checkout with payment events and transaction records.
     *
     * @var string
     */
    public string $clientTransactionId;

}
