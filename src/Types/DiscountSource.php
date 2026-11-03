<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The source of discount. Exactly one property must be set.
 */
class DiscountSource
{
    /**
     * Discount created ad-hoc on device during checkout.
     *
     * @var DiscountSourceAdHoc|null
     */
    public ?DiscountSourceAdHoc $adHoc = null;

    /**
     * Preset discount applied manually on the POS.
     *
     * @var DiscountSourceBasic|null
     */
    public ?DiscountSourceBasic $basic = null;

    /**
     * Discount applied manually when entering a coupon code at checkout.
     *
     * @var DiscountSourceCoupon|null
     */
    public ?DiscountSourceCoupon $coupon = null;

    /**
     * Discount applied automatically when cart is updated based on preset promotions.
     *
     * @var DiscountSourceOffer|null
     */
    public ?DiscountSourceOffer $offer = null;

    /**
     * Discount applied when redeeming a reward from the merchant's loyalty scheme.
     *
     * @var DiscountSourceLoyalty|null
     */
    public ?DiscountSourceLoyalty $loyalty = null;

}
