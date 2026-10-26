<?php

declare(strict_types=1);

namespace SumUp\Types;

class UpdateReaderSettingsResponseData
{
    /**
     * Settings included in the update. Omitted fields are not returned.
     *
     * @var UpdateReaderSettingsResponseDataMenuLock
     */
    public UpdateReaderSettingsResponseDataMenuLock $menuLock;

    /**
     * Indicates that the reader applied the settings update.
     *
     * @var UpdateReaderSettingsResponseDataStatus
     */
    public UpdateReaderSettingsResponseDataStatus $status;

}
