<?php

declare(strict_types=1);

namespace SumUp\Types;

class Customer
{
    /**
     * Unique ID of the customer.
     *
     * @var string
     */
    public string $customerId;

    /**
     * Personal details for the customer.
     *
     * @var PersonalDetails|null
     */
    public ?PersonalDetails $personalDetails = null;

}
