<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Price information with positive amounts and detailed tax breakdown.
 */
class PositivePriceWithTaxes
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

    /**
     * Taxes applied on top of net amount resulting in gross amount.
     *
     * @var PositiveTaxLine[]
     */
    public array $taxes;

}
