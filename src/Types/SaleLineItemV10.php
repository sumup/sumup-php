<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * A single line of a sale.
 *
 * The envelope (id, type, name, quantity, unit_of_measure, price) is stable and
 * type-agnostic: any consumer can render and total a line from these fields alone.
 * Type-specific data is in `features`. There is no per-type object and no discriminator,
 * so a new item type does not change this schema.
 */
class SaleLineItemV10
{
    /**
     * Stable identifier of the line within the sale. Used for linking (e.g. deposits).
     *
     * @var string
     */
    public string $id;

    /**
     * Classifies a sale line. Not a schema subclass.
     * Known values: `CATALOG`, `DEPOSIT`, `GIFT_CARD`, `CUSTOM`, `FEE`.
     * `FEE` lines represent merchant-charged fees on the sale (e.g. shipping, service
     * charge, surcharge, cancellation). They participate in sale totals like any other
     * line; type-specific data is carried in `features` (see `Feature` for the
     * conventional feature keys).
     * This is intentionally an open string, NOT a closed enum: new values are added
     * over time as pure data and consumers MUST tolerate unknown values, rendering the
     * line from the generic envelope (name, quantity, price, taxes) and reading any
     * extra information from `features`.
     *
     * @var string
     */
    public string $type;

    /**
     * Display name of the line.
     *
     * @var string
     */
    public string $name;

    /**
     * The numerical value representing the quantity in the specified unit.
     *
     * @var float
     */
    public float $quantity;

    /**
     * The unit of measure of the item.
     *
     * @var UnitOfMeasure
     */
    public UnitOfMeasure $unitOfMeasure;

    /**
     * The type of service for this line.
     *
     * @var SaleLineItemV10ServiceType|null
     */
    public ?SaleLineItemV10ServiceType $serviceType = null;

    /**
     * Optional free-text note attached to the line, visible on receipts.
     *
     * @var string|null
     */
    public ?string $note = null;

    /**
     * Pricing for a single line, valid for every item type.
     * Merges the standard amounts (with tax breakdown) and the final amounts (after
     * discounts/modifiers).
     * Totals and tax amounts can be negative for return-like operations (for example
     * a deposit with `operation_type` = `RETURN`).
     *
     * @var LineItemPriceV10
     */
    public LineItemPriceV10 $price;

    /**
     * Categories the line belongs to. A shared optional structure available to any
     * line; not a per-type field.
     *
     * @var CategoryV10[]|null
     */
    public ?array $categories = null;

    /**
     * Modifiers customise a line (e.g. "oat milk" on a cappuccino). A shared
     * optional structure available to any line; not a per-type field.
     *
     * @var ModifierItem[]|null
     */
    public ?array $modifiers = null;

    /**
     * Outward identifiers and links for a line, kept in one place rather than scattered
     * per item type.
     *
     * @var ItemReferencesV10|null
     */
    public ?ItemReferencesV10 $references = null;

    /**
     * Named, typed, type-specific data. New item types add their data here as
     * features instead of new schema variants. See `Feature` for per-type examples.
     *
     * @var FeatureV10[]|null
     */
    public ?array $features = null;

}
