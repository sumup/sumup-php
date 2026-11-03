<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Object representing information about single discount line.
 */
class DiscountLine
{
    /**
     * An id used to associate a discount line with a specific discount.
     * Since we can apply multiple discounts (e.g. 2x 10% whole cart off)
     * we need to be able to identify which discount line belongs to which cart discount.
     * Recommended to use UUID identifiers.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * A description or reason of the discount.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Specifies where discount was applied by user (either merchant or consumer):
     * - CART: Applied to the whole cart (calculated and distributed per sale item)
     * - ITEM: Applied to specific sale item
     * *Accepted values:* ["ITEM", "CART"].
     *
     * @var string
     */
    public string $level;

    /**
     * The source of discount. Exactly one property must be set.
     *
     * @var DiscountSource
     */
    public DiscountSource $source;

    /**
     * The value type of the discount, either a percentage based or absolute monetary value.
     * It is required that only one of the following is set:
     * - absolute
     * - percentage.
     *
     * @var DiscountValue
     */
    public DiscountValue $value;

    /**
     * The net amount of the discount.
     * The value of the amount in minor units of the currency according to the Sale.currency.scale.
     *
     * @var int
     */
    public int $netAmount;

    /**
     * The gross amount of the discount.
     * The value of the amount in minor units of the currency according to the Sale.currency.scale.
     *
     * @var int
     */
    public int $grossAmount;

    /**
     * The tax amount of the discount.
     * The value of the amount in minor units of the currency according to the Sale.currency.scale.
     *
     * @var int
     */
    public int $taxAmount;

}
