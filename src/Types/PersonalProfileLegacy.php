<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Account's personal profile.
 */
class PersonalProfileLegacy
{
    /**
     * First name of the user
     *
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * Last name of the user
     *
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * Date of birth
     *
     * @var string|null
     */
    public ?string $dateOfBirth = null;

    /**
     * Mobile phone number
     *
     * @var string|null
     */
    public ?string $mobilePhone = null;

    /**
     * Details of the registered address.
     *
     * @var AddressWithDetails|null
     */
    public ?AddressWithDetails $address = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $complete = null;

}
