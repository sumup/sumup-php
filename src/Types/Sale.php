<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Core model of the Sales API. Returned by `GET /sales` and `GET /sales/{sale_id}`.
 *
 * Non-finalised sales are never returned; only fully-paid sales.
 *
 * Item lines are `SaleLineItem`. Merchant fees appear as `type: "FEE"` lines; extra fee data
 * is in `features`.
 */
class Sale
{
    /**
     * The ID of the sale.
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
     * The currency of the sale.
     *
     * @var SalesActivityCurrency
     */
    public SalesActivityCurrency $currency;

    /**
     * Human-readable name of the sale (not unique, not the sale id).
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Optional note attached to the sale, visible on receipts and the UI.
     *
     * @var string|null
     */
    public ?string $note = null;

    /**
     * The lines sold in this sale, in the order they were added to the cart.
     * Includes merchant fees (`type: "FEE"`) when present; fee details are in `features`.
     *
     * @var SaleLineItemV10[]
     */
    public array $items;

    /**
     * Sale-level pricing aggregate, parallel to `LineItemPrice` on each `SaleLineItem`.
     * Line-level breakdown (unit price, line discounts, per-line taxes) lives on
     * `items[].price`. This object holds the rolled-up totals and cart-level
     * adjustments that consumers use for receipts and payment reconciliation.
     *
     * @var SalePriceV10
     */
    public SalePriceV10 $price;

    /**
     * The tax mode used by merchant for displaying prices and calculating taxes:
     * - NO_TAX: The prices don't contain any taxes, merchant don't report taxes
     * - GROSS: The prices used by merchant already include taxes (common in EU), the tax is calculated from the gross price
     * - NET: The prices used by merchant don't include taxes (common in US), the tax is calculated from the net price
     * Since tax values can be different for the same net price depending if the tax
     * was calculated from gross or net price, this info is necessary to be able to reconcile tax calculations.
     *
     * @var SaleTaxMode
     */
    public SaleTaxMode $taxMode;

    /**
     * Information about the source of the sale.
     *
     * @var SaleSource
     */
    public SaleSource $source;

    /**
     * Payments on this sale, in the order they were recorded.
     *
     * @var PublicPaymentV10[]
     */
    public array $payments;

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

    /**
     * Lifecycle state of the sale.
     * Non-finalised sales are never returned; only fully-paid sales.
     *
     * @var SaleState
     */
    public SaleState $state;

}
