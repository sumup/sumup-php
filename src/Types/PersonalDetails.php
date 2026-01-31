<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Personal details for the customer.
 */
class PersonalDetails
{
    /**
     * First name of the customer.
     *
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * Last name of the customer.
     *
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * Email address of the customer.
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     * Phone number of the customer.
     *
     * @var string|null
     */
    public ?string $phone = null;

    /**
     * Date of birth of the customer.
     *
     * @var string|null
     */
    public ?string $birthDate = null;

    /**
     * An identification number user for tax purposes (e.g. CPF)
     *
     * @var string|null
     */
    public ?string $taxId = null;

    /**
     * Profile's personal address information.
     *
     * @var AddressLegacy|null
     */
    public ?AddressLegacy $address = null;

}
