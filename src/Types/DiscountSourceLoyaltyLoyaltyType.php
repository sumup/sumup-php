<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The type of loyalty discount, either a promotion (e.g. new customer discount) or a reward (free coffee after completing stamp card).
 */
enum DiscountSourceLoyaltyLoyaltyType: string
{
    case PROMOTION = 'PROMOTION';
    case REWARD = 'REWARD';
}
