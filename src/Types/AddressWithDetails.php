<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of the registered address.
 */
class AddressWithDetails
{
    /**
     * Address line 1
     *
     * @var string|null
     */
    public ?string $addressLine1 = null;

    /**
     * Address line 2
     *
     * @var string|null
     */
    public ?string $addressLine2 = null;

    /**
     * City
     *
     * @var string|null
     */
    public ?string $city = null;

    /**
     * Country ISO 3166-1 code
     *
     * @var string|null
     */
    public ?string $country = null;

    /**
     * Country region id
     *
     * @var float|null
     */
    public ?float $regionId = null;

    /**
     * Region name
     *
     * @var string|null
     */
    public ?string $regionName = null;

    /**
     * Region code
     *
     * @var string|null
     */
    public ?string $regionCode = null;

    /**
     * Postal code
     *
     * @var string|null
     */
    public ?string $postCode = null;

    /**
     * Landline number
     *
     * @var string|null
     */
    public ?string $landline = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $company = null;

    /**
     * Country Details
     *
     * @var CountryDetails|null
     */
    public ?CountryDetails $countryDetails = null;

    /**
     * TimeOffset Details
     *
     * @var TimeoffsetDetails|null
     */
    public ?TimeoffsetDetails $timeoffsetDetails = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $stateId = null;

}
