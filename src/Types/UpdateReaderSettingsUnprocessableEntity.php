<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The reader cannot complete the settings request, or the settings are invalid.
 */
class UpdateReaderSettingsUnprocessableEntity
{
    /**
     *
     * @var array<string, mixed>
     */
    public array $errors;

}
