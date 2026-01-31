<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Current status of the transaction.
 */
enum TransactionBaseStatus: string
{
    case SUCCESSFUL = 'SUCCESSFUL';
    case CANCELLED = 'CANCELLED';
    case FAILED = 'FAILED';
    case PENDING = 'PENDING';
}
