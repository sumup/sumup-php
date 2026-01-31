<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Status generated from the processing status and the latest transaction state.
 */
enum ModelSimpleStatus: string
{
    case SUCCESSFUL = 'SUCCESSFUL';
    case PAID_OUT = 'PAID_OUT';
    case CANCEL_FAILED = 'CANCEL_FAILED';
    case CANCELLED = 'CANCELLED';
    case CHARGEBACK = 'CHARGEBACK';
    case FAILED = 'FAILED';
    case REFUND_FAILED = 'REFUND_FAILED';
    case REFUNDED = 'REFUNDED';
    case NON_COLLECTION = 'NON_COLLECTION';
}
