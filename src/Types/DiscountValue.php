<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The value type of the discount, either a percentage based or absolute monetary value.
 *
 * It is required that only one of the following is set:
 * - absolute
 * - percentage.
 */
class DiscountValue
{
    /**
     * The absolute value in minor units of the currency according to the Sale.currency.scale.
     * Example: 10000 = 10.00
     *
     * @var int|null
     */
    public ?int $absolute = null;

    /**
     * The percentage in minor units (1/100000).
     * Examples:
     * - 10% -> 0.10 (decimal) = 10000 (minor units)
     * - 15.5% -> 0.155 (decimal) = 15500 (minor units)
     * - 0.001% -> 0.00001 (decimal) = 1 (minor units)
     *
     * @var int|null
     */
    public ?int $percentage = null;

}
