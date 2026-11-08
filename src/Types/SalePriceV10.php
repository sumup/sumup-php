<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Sale-level pricing aggregate, parallel to `LineItemPrice` on each `SaleLineItem`.
 *
 * Line-level breakdown (unit price, line discounts, per-line taxes) lives on
 * `items[].price`. This object holds the rolled-up totals and cart-level
 * adjustments that consumers use for receipts and payment reconciliation.
 */
class SalePriceV10
{
    /**
     * Final net total for the sale: sum of `items[].price.total_net_amount_final`
     * after cart-level discounts (tips excluded).
     * In minor units according to `Sale.currency.scale`.
     *
     * @var int
     */
    public int $netAmount;

    /**
     * Final gross total for the sale: sum of `items[].price.total_gross_amount_final`
     * after cart-level discounts (tips excluded).
     * Same value as search `total_amount`, in minor units according to `Sale.currency.scale`.
     * Payment amounts include tips and can therefore differ from this gross total.
     *
     * @var int
     */
    public int $grossAmount;

    /**
     * Discounts applied at cart level. Item-level discounts remain on
     * `items[].price.discounts`.
     *
     * @var DiscountLine[]|null
     */
    public ?array $cartDiscounts = null;

    /**
     * Tax lines aggregated across the sale (after cart-level discounts).
     * Per-line tax detail remains on `items[].price.taxes` / `taxes_final`.
     *
     * @var TaxLine[]
     */
    public array $taxes;

}
