<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Amount to charge in minor units. Use the decimal places for the currency.
 * CLP, COP, and HUF use zero decimal places.
 *
 * For example, send `1234` for EUR 12.34 or `1000` for CLP 1000.
 *
 */
class CreateReaderCheckoutRequestTotalAmount
{
    /**
     * Currency ISO 4217 code
     *
     * @var string
     */
    public string $currency;

    /**
     * Integer value of the amount.
     *
     * @var int
     */
    public int $value;

}
