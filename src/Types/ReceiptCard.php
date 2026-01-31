<?php

declare(strict_types=1);

namespace SumUp\Types;

class ReceiptCard
{
    /**
     * Card last 4 digits.
     *
     * @var string|null
     */
    public ?string $last4Digits = null;

    /**
     * Card Scheme.
     *
     * @var string|null
     */
    public ?string $type = null;

}
