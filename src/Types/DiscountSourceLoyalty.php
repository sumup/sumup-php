<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Discount applied when redeeming a reward from the merchant's loyalty scheme.
 */
class DiscountSourceLoyalty
{
    /**
     * The unique identifier of the promotion or reward.
     *
     * @var string
     */
    public string $id;

    /**
     * The type of loyalty discount, either a promotion (e.g. new customer discount) or a reward (free coffee after completing stamp card).
     *
     * @var DiscountSourceLoyaltyLoyaltyType
     */
    public DiscountSourceLoyaltyLoyaltyType $loyaltyType;

    /**
     * The scheme type of the loyalty program.
     *
     * @var DiscountSourceLoyaltySchemeType
     */
    public DiscountSourceLoyaltySchemeType $schemeType;

    /**
     * The number of points used for this loyalty discount.
     * Must be a positive integer if the scheme type is POINTS.
     * Must not be populated if the scheme type is STAMPS.
     *
     * @var int|null
     */
    public ?int $points = null;

    /**
     * The name of the loyalty discount.
     *
     * @var string
     */
    public string $name;

    /**
     * The description of the loyalty discount.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * The method used to target items to discount.
     * Must be populated for ITEM level discounts, and must be null for CART level discounts (CART level targets all
     * items, therefore none of these categories apply).
     *
     * @var DiscountSourceLoyaltyDiscountClass|null
     */
    public ?DiscountSourceLoyaltyDiscountClass $discountClass = null;

    /**
     * Method of applying the discount to the items or cart.
     *
     * @var DiscountSourceLoyaltyApplicationMode
     */
    public DiscountSourceLoyaltyApplicationMode $applicationMode;

}
