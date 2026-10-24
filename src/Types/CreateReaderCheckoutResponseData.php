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
     * **SumUp API flow.** Unique identifier for this checkout-generated transaction.
     * Pass this value as `terminal.client_id` when the reader creates the terminal so
     * checkout metadata (including affiliate sent here) is merged into the payment.
     * SDK clients do not use this field for affiliate metadata; they send affiliate in
     * `terminal.affiliate` on `POST /api/terminals` instead.
     *
     * @var string
     */
    public string $clientTransactionId;

}
