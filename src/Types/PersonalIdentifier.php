<?php

declare(strict_types=1);

namespace SumUp\Types;

class PersonalIdentifier
{
    /**
     * The unique reference for the personal identifier type as defined in the country SDK.
     *
     * @var string
     */
    public string $ref;

    /**
     * The company identifier value.
     *
     * @var string
     */
    public string $value;

}
