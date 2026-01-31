<?php

declare(strict_types=1);

namespace SumUp\Types;

class Ownership
{
    /**
     * The percent of ownership shares held by the person expressed in percent mille (1/100000). Only persons with the relationship `owner` can have ownership.
     *
     * @var int
     */
    public int $share;

}
