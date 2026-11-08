<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Summary row for a sale in search results. Use `GET /sales/{sale_id}` for the full `Sale`.
 */
class SaleSearchItem
{
    /**
     * Sale identifier.
     *
     * @var string
     */
    public string $id;

    /**
     * Identity UUID of the cashier who processed the sale. Omitted when the cashier
     * identity is unknown.
     *
     * @var string|null
     */
    public ?string $userId = null;

    /**
     * Lifecycle state of the sale.
     * Non-finalised sales are never returned; only fully-paid sales.
     *
     * @var SaleSearchItemState
     */
    public SaleSearchItemState $state;

    /**
     * Display name of the sale when set; otherwise a concatenation of item names with
     * quantities. Omitted when neither is available.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Checkout tax mode for the sale. Same values as `Sale.tax_mode`.
     *
     * @var SaleSearchItemTaxMode
     */
    public SaleSearchItemTaxMode $taxMode;

    /**
     * The currency of the sale.
     *
     * @var SalesActivityCurrency
     */
    public SalesActivityCurrency $currency;

    /**
     * Final sale gross total after discounts and taxes, excluding tips.
     * Same value as `Sale.price.gross_amount`, in minor units according to `currency.scale`.
     * Payment amounts include tips and can therefore differ from this total.
     *
     * @var int
     */
    public int $totalAmount;

    /**
     * Instant when the sale was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * Instant when the sale was closed. Always present: non-finalised sales are never returned.
     *
     * @var string
     */
    public string $closedAt;

}
