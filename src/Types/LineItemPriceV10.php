<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Pricing for a single line, valid for every item type.
 *
 * Merges the standard amounts (with tax breakdown) and the final amounts (after
 * discounts/modifiers).
 *
 * Totals and tax amounts can be negative for return-like operations (for example
 * a deposit with `operation_type` = `RETURN`).
 */
class LineItemPriceV10
{
    /**
     * The price of a single unit. If the tax_mode is GROSS it includes taxes,
     * otherwise no tax is included. It does NOT include discounts.
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
     * Taxes applied on top of the net amount resulting in the gross amount.
     *
     * @var TaxLine[]
     */
    public array $taxes;

    /**
     * Discounts applied. Discount amounts do not affect `total_net_amount` /
     * `total_gross_amount`; they are reflected in the `*_final` amounts.
     *
     * @var DiscountLine[]|null
     */
    public ?array $discounts = null;

    /**
     * The final net amount including discounts and modifiers. Equals `total_net_amount` if no discounts apply.
     *
     * @var int
     */
    public int $totalNetAmountFinal;

    /**
     * The final gross amount including discounts, modifiers and taxes. Equals `total_gross_amount` if no discounts apply.
     *
     * @var int
     */
    public int $totalGrossAmountFinal;

    /**
     * Taxes applied on top of `total_net_amount_final` resulting in `total_gross_amount_final`. Equals `taxes` if no discounts apply.
     *
     * @var TaxLine[]
     */
    public array $taxesFinal;

}
