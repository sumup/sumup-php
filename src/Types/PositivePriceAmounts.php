<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Price information for items with positive amounts only.
 */
class PositivePriceAmounts
{
    /**
     * The price of a single unit.
     * If the tax_mode is GROSS, it includes taxes, otherwise no tax included.
     * It doesn't include discounts.
     *
     * @var int
     */
    public int $unitAmount;

    /**
     * The net amount (including modifiers if applied). It does NOT include discounts.
     *
     * @var int
     */
    public int $totalNetAmount;

    /**
     * The gross amount (including modifiers if applied). It does NOT include discounts.
     *
     * @var int
     */
    public int $totalGrossAmount;

}
