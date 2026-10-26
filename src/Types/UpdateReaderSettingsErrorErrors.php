<?php

declare(strict_types=1);

namespace SumUp\Types;

class UpdateReaderSettingsErrorErrors
{
    /**
     * Error message
     *
     * @var string
     */
    public string $detail;

    /**
     * Error code
     *
     * @var string|null
     */
    public ?string $type = null;

}
