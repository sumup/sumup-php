<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Doing Business As information
 */
class DoingBusinessAsLegacy
{
    /**
     * Doing business as name
     *
     * @var string|null
     */
    public ?string $businessName = null;

    /**
     * Doing business as company registration number
     *
     * @var string|null
     */
    public ?string $companyRegistrationNumber = null;

    /**
     * Doing business as VAT ID
     *
     * @var string|null
     */
    public ?string $vatId = null;

    /**
     * Doing business as website
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     * Doing business as email
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     *
     * @var array|null
     */
    public ?array $address = null;

}
