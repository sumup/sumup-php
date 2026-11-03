<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The scheme type of the loyalty program.
 */
enum DiscountSourceLoyaltySchemeType: string
{
    case STAMPS = 'STAMPS';
    case POINTS = 'POINTS';
}
