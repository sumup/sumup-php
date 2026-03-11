<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Error message structure.
 */
class DetailsError
{
    /**
     * Short title of the error.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * Details of the error.
     *
     * @var string|null
     */
    public ?string $details = null;

    /**
     * The status code.
     *
     * @var float|null
     */
    public ?float $status = null;

    /**
     * List of violated validation constraints.
     *
     * @var array<string, mixed>[]|null
     */
    public ?array $failedConstraints = null;

}
