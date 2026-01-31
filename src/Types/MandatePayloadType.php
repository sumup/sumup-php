<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Indicates the mandate type
 */
enum MandatePayloadType: string
{
    case RECURRENT = 'recurrent';
}
