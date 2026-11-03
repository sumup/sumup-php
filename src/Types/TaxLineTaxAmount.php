<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Amount of tax.
 * The value of the amount in minor units of the currency according to the Sale.currency.scale.
 *
 */
class TaxLineTaxAmount
{
    /**
     * Currency ISO 4217 code
     *
     * @var string
     */
    public string $currency;

    /**
     * Amount in minor units (e.g. cents).
     *
     * @var int
     */
    public int $value;

}
