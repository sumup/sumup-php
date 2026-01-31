<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Merchant VAT rates
 */
class VatRates
{
    /**
     * Internal ID
     *
     * @var float|null
     */
    public ?float $id = null;

    /**
     * Description
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Rate
     *
     * @var float|null
     */
    public ?float $rate = null;

    /**
     * Ordering
     *
     * @var float|null
     */
    public ?float $ordering = null;

    /**
     * Country ISO code
     *
     * @var string|null
     */
    public ?string $country = null;

}
