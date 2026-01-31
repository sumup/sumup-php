<?php

declare(strict_types=1);

namespace SumUp\Types;

class BaseError
{
    /**
     * A unique identifier for the error instance. This can be used to trace the error back to the server logs.
     *
     * @var string|null
     */
    public ?string $instance = null;

    /**
     * A human-readable message describing the error that occurred.
     *
     * @var string|null
     */
    public ?string $message = null;

}
