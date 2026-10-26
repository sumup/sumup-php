<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Settings included in the update. Omitted fields are not returned.
 */
class UpdateReaderSettingsResponseDataMenuLock
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
