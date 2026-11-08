<?php

declare(strict_types=1);

namespace SumUp\Types;

class MerchantsPersonalIdentifiersItem
{
    /**
     * The unique reference for the personal identifier type as defined in the country SDK.
     *
     * @var string
     */
    public string $ref;

    /**
     * The value of the personal identifier.
     *
     * @var string
     */
    public string $value;

}
