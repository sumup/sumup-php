<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The currency of the sale.
 */
class SalesActivityCurrency
{
    /**
     * 3-letter currency code as defined by ISO-4217.
     *
     * @var string
     */
    public string $code;

    /**
     * The scaling factor to apply to the value to arrive at the currency's major unit. Providing a scale mitigates changes to the minor unit over time, for example due to inflation. For example, if `scale` is denoted by `s` and `value` is denoted by  `v` is the value, then one arrives at the major currency value by calculating `v / 10^s`.
     *
     * @var int
     */
    public int $scale;

}
