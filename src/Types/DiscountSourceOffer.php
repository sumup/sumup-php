<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Discount applied automatically when cart is updated based on preset promotions.
 */
class DiscountSourceOffer
{
    /**
     * The unique identifier of the offer discount.
     *
     * @var string
     */
    public string $id;

    /**
     * The name of the offer discount.
     *
     * @var string
     */
    public string $name;

    /**
     * The description of the offer discount.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * The method used to target items to discount.
     * Must be populated for ITEM level discounts, and must be null for CART level discounts (CART level targets all
     * items, therefore none of these categories apply).
     *
     * @var DiscountSourceOfferDiscountClass|null
     */
    public ?DiscountSourceOfferDiscountClass $discountClass = null;

    /**
     * Method of applying the discount to the items or cart.
     *
     * @var DiscountSourceOfferApplicationMode
     */
    public DiscountSourceOfferApplicationMode $applicationMode;

}
