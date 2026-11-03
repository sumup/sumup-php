<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Final price amounts after all calculations and adjustments.
 */
class FinalPriceAmounts
{
    /**
     * Discounts applied.
     * Important:
     * Discount amounts shouldn't take effect on net and gross amounts.
     * Discount money amounts depend on where discount was applied:
     * - for item level discount: whole discount money amount is applied
     * - for cart level discount: only part of the whole amount is applied
     * (discount money value is split on each line item)
     *
     * @var DiscountLine[]|null
     */
    public ?array $discounts = null;

    /**
     * The final net amount includes discounts and modifiers. It does NOT include taxes. If no discounts are applied, it should be equal to total_net_amount.
     *
     * @var int
     */
    public int $totalNetAmountFinal;

    /**
     * The final gross amount includes discounts, modifiers, and taxes. If no discounts are applied, it should be equal to total_gross_amount.
     *
     * @var int
     */
    public int $totalGrossAmountFinal;

    /**
     * Taxes applied on top of `total_net_amount_final` amount resulting in `total_gross_amount_final` amount.
     * If no discounts are applied, it should be equal to `taxes`.
     *
     * @var PositiveTaxLine[]
     */
    public array $taxesFinal;

}
