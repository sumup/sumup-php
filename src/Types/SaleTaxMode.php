<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The tax mode used by merchant for displaying prices and calculating taxes:
 * - NO_TAX: The prices don't contain any taxes, merchant don't report taxes
 * - GROSS: The prices used by merchant already include taxes (common in EU), the tax is calculated from the gross price
 * - NET: The prices used by merchant don't include taxes (common in US), the tax is calculated from the net price
 * Since tax values can be different for the same net price depending if the tax
 * was calculated from gross or net price, this info is necessary to be able to reconcile tax calculations.
 *
 */
enum SaleTaxMode: string
{
    case NO_TAX = 'NO_TAX';
    case GROSS = 'GROSS';
    case NET = 'NET';
}
