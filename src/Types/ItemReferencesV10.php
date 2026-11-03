<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Outward identifiers and links for a line, kept in one place rather than scattered
 * per item type.
 */
class ItemReferencesV10
{
    /**
     * The source of the catalog the line originates from.
     *
     * @var ItemReferencesV10CatalogSource|null
     */
    public ?ItemReferencesV10CatalogSource $catalogSource = null;

    /**
     * Reference to the backing catalog entity (item variant, deposit, ...),
     * typically a URN such as
     * `urn:sumup:pos:variant:${MERCHANT_CODE}:${ITEM_ID}:${VARIANT_ID}` or
     * `urn:sumup:pos:deposit:${MERCHANT_CODE}:${DEPOSIT_ID}`.
     * Empty for ad-hoc / manual lines. Type-agnostic on purpose: a new item type
     * backed by a catalog entity reuses this field instead of adding its own.
     *
     * @var string|null
     */
    public ?string $catalogReference = null;

    /**
     * An external reference id connecting this line to another system.
     *
     * @var string|null
     */
    public ?string $externalId = null;

    /**
     * Stock keeping unit, enriched from the Catalog when available.
     *
     * @var string|null
     */
    public ?string $sku = null;

}
