<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Checkout tax mode for the sale. Same values as `Sale.tax_mode`.
 */
enum SaleSearchItemTaxMode: string
{
    case NO_TAX = 'NO_TAX';
    case GROSS = 'GROSS';
    case NET = 'NET';
}
