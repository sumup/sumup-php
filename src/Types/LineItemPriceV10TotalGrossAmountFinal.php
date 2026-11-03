<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The final gross amount including discounts, modifiers and taxes. Equals `total_gross_amount` if no discounts apply.
 */
class LineItemPriceV10TotalGrossAmountFinal
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
