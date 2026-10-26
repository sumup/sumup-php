<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Menu lock configuration. Fields may be absent if no value is available.
 */
class GetReaderSettingsResponseDataMenuLock
{
    /**
     * Whether menu lock is enabled.
     *
     * @var bool|null
     */
    public ?bool $enabled = null;

    /**
     * Four-digit PIN used to unlock the reader's menu.
     *
     * @var string|null
     */
    public ?string $passcode = null;

}
