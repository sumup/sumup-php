<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Final net total for the sale: sum of `items[].price.total_net_amount_final`
 * after cart-level discounts (tips excluded).
 * In minor units according to `Sale.currency.scale`.
 */
class SalePriceV10NetAmount
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
