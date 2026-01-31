<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Country Details
 */
class CountryDetails
{
    /**
     * Currency ISO 4217 code
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     * Country ISO code
     *
     * @var string|null
     */
    public ?string $isoCode = null;

    /**
     * Country EN name
     *
     * @var string|null
     */
    public ?string $enName = null;

    /**
     * Country native name
     *
     * @var string|null
     */
    public ?string $nativeName = null;

}
