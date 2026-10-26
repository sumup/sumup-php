<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Details of a customer validation error.
 */
class CustomerValidationError
{
    /**
     * Unique identifier of this error occurrence.
     *
     * @var string
     */
    public string $instance;

    /**
     * Platform code for the error.
     *
     * @var string
     */
    public string $errorCode;

    /**
     * Short description of the error.
     *
     * @var string
     */
    public string $errorMessage;

}
