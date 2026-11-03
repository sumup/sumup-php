<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Method of applying the discount to the items or cart.
 */
enum DiscountSourceLoyaltyApplicationMode: string
{
    case MANUAL = 'MANUAL';
    case AUTOMATIC = 'AUTOMATIC';
}
