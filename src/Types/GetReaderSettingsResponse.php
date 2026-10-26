<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Menu lock settings reported by the reader, or the last saved settings when offline.
 *
 */
class GetReaderSettingsResponse
{
    /**
     *
     * @var GetReaderSettingsResponseData
     */
    public GetReaderSettingsResponseData $data;

}
