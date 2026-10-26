<?php

declare(strict_types=1);

namespace SumUp\Types;

class GetReaderSettingsResponseData
{
    /**
     * Menu lock configuration. Fields may be absent if no value is available.
     *
     * @var GetReaderSettingsResponseDataMenuLock
     */
    public GetReaderSettingsResponseDataMenuLock $menuLock;

}
