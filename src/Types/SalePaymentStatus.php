<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The status of the payment.
 */
enum SalePaymentStatus: string
{
    case FAILED = 'FAILED';
    case SUCCESSFUL = 'SUCCESSFUL';
    case CANCELED = 'CANCELED';
}
