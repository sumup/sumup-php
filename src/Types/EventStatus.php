<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Status of the transaction event.
 */
enum EventStatus: string
{
    case FAILED = 'FAILED';
    case PAID_OUT = 'PAID_OUT';
    case PENDING = 'PENDING';
    case RECONCILED = 'RECONCILED';
    case REFUNDED = 'REFUNDED';
    case SCHEDULED = 'SCHEDULED';
    case SUCCESSFUL = 'SUCCESSFUL';
}
