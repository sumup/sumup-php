<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * TimeOffset Details
 */
class TimeoffsetDetails
{
    /**
     * Postal code
     *
     * @var string|null
     */
    public ?string $postCode = null;

    /**
     * UTC offset
     *
     * @var float|null
     */
    public ?float $offset = null;

    /**
     * Daylight Saving Time
     *
     * @var bool|null
     */
    public ?bool $dst = null;

}
