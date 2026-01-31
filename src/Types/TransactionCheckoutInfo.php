<?php

declare(strict_types=1);

namespace SumUp\Types;

class TransactionCheckoutInfo
{
    /**
     * Unique code of the registered merchant to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Amount of the applicable VAT (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Amount of the tip (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $tipAmount = null;

    /**
     * Entry mode of the payment details.
     *
     * @var TransactionCheckoutInfoEntryMode|null
     */
    public ?TransactionCheckoutInfoEntryMode $entryMode = null;

    /**
     * Authorization code for the transaction sent by the payment card issuer or bank. Applicable only to card payments.
     *
     * @var string|null
     */
    public ?string $authCode = null;

    /**
     * Internal unique ID of the transaction on the SumUp platform.
     *
     * @var int|null
     */
    public ?int $internalId = null;

}
