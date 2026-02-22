<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of the payment card.
 */
class CardResponse
{
    /**
     * Last 4 digits of the payment card number.
     *
     * @var string|null
     */
    public ?string $last4Digits = null;

    /**
     * Issuing card network of the payment card used for the transaction.
     *
     * @var CardResponseType|null
     */
    public ?CardResponseType $type = null;

}
