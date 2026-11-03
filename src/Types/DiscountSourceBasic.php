<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Preset discount applied manually on the POS.
 */
class DiscountSourceBasic
{
    /**
     * The unique identifier of the basic discount.
     *
     * @var string
     */
    public string $id;

    /**
     * The name of the basic discount.
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
     * Method of applying the discount to the items or cart.
     *
     * @var DiscountSourceBasicApplicationMode
     */
    public DiscountSourceBasicApplicationMode $applicationMode;

}
