<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The method used to target items to discount.
 * Must be populated for ITEM level discounts, and must be null for CART level discounts (CART level targets all
 * items, therefore none of these categories apply).
 *
 */
enum DiscountSourceLoyaltyDiscountClass: string
{
    case ITEM = 'ITEM';
    case CATEGORY = 'CATEGORY';
    case BUNDLE = 'BUNDLE';
    case BUY_X_GET_Y = 'BUY_X_GET_Y';
    case MEAL_DEAL = 'MEAL_DEAL';
}
