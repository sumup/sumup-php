<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The final net amount including discounts and modifiers. Equals `total_net_amount` if no discounts apply.
 */
class LineItemPriceV10TotalNetAmountFinal
{
    /**
     * Currency ISO 4217 code
     *
     * @var string
     */
    public string $currency;

    /**
     * Amount in minor units (e.g. cents).
     *
     * @var int
     */
    public int $value;

}
