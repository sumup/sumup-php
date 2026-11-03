<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Final gross total for the sale: sum of `items[].price.total_gross_amount_final`
 * after cart-level discounts (tips excluded).
 * Same value as search `total_amount`, in minor units according to `Sale.currency.scale`.
 * Payment amounts include tips and can therefore differ from this gross total.
 */
class SalePriceV10GrossAmount
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
