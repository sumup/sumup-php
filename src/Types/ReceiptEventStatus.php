<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Status of the transaction event.
 */
enum ReceiptEventStatus: string
{
    case PENDING = 'PENDING';
    case SCHEDULED = 'SCHEDULED';
    case FAILED = 'FAILED';
    case REFUNDED = 'REFUNDED';
    case SUCCESSFUL = 'SUCCESSFUL';
    case PAID_OUT = 'PAID_OUT';
}
