<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Discount applied manually when entering a coupon code at checkout.
 */
class DiscountSourceCoupon
{
    /**
     * The unique identifier of the coupon discount.
     *
     * @var string
     */
    public string $id;

    /**
     * The coupon code.
     *
     * @var string
     */
    public string $code;

    /**
     * The name of the coupon discount.
     *
     * @var string
     */
    public string $name;

    /**
     * The description of the coupon discount.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * The method used to target items to discount.
     * Must be populated for ITEM level discounts, and must be null for CART level discounts (CART level targets all
     * items, therefore none of these categories apply).
     *
     * @var DiscountSourceCouponDiscountClass|null
     */
    public ?DiscountSourceCouponDiscountClass $discountClass = null;

    /**
     * Method of applying the discount to the items or cart.
     *
     * @var DiscountSourceCouponApplicationMode
     */
    public DiscountSourceCouponApplicationMode $applicationMode;

}
