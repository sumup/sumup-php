<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Modifiers are reported under line items and can be build from Item Catalog objects.
 * Modifiers has to be attached to an item and can't be sold and refunded alone.
 */
class ModifierItem
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

    /**
     * Taxes applied on top of net amount resulting in gross amount.
     *
     * @var PositiveTaxLine[]
     */
    public array $taxes;

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

    /**
     * Modifier id, coming from the Item Catalog
     *
     * @var string
     */
    public string $id;

    /**
     * Modifier name, coming from the Item Catalog
     *
     * @var string
     */
    public string $name;

    /**
     * Modifier set attached to an item.
     *
     * @var ModifierSet
     */
    public ModifierSet $set;

    /**
     * The numerical value representing the quantity in the specified unit.
     *
     * @var float
     */
    public float $quantity;

}
