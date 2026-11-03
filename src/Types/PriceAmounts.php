<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Base price information for items including unit amount and totals.
 */
class PriceAmounts
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
     * @var mixed
     */
    public mixed $totalNetAmount;

    /**
     * The gross amount (including modifiers if applied). It does NOT include discounts.
     *
     * @var mixed
     */
    public mixed $totalGrossAmount;

}
