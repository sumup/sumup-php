<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Discount created ad-hoc on device during checkout.
 */
class DiscountSourceAdHoc
{
    /**
     * The unique identifier of the ad-hoc discount.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * The name of the ad-hoc discount.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The description of the ad-hoc discount.
     *
     * @var string|null
     */
    public ?string $description = null;

}
