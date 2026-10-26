<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Indicates that the reader applied the settings update.
 */
enum UpdateReaderSettingsResponseDataStatus: string
{
    case APPLIED = 'applied';
}
