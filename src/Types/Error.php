<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Error message structure.
 */
class Error
{
    /**
     * Short description of the error.
     *
     * @var string|null
     */
    public ?string $message = null;

    /**
     * Platform code for the error.
     *
     * @var string|null
     */
    public ?string $errorCode = null;

}
