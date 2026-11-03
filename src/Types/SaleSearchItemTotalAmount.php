<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Final sale gross total after discounts and taxes, excluding tips.
 * Same value as `Sale.price.gross_amount`, in minor units according to `currency.scale`.
 * Payment amounts include tips and can therefore differ from this total.
 */
class SaleSearchItemTotalAmount
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
