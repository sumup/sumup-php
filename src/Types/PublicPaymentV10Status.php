<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The status of the payment.
 */
enum PublicPaymentV10Status: string
{
    case FAILED = 'FAILED';
    case SUCCESSFUL = 'SUCCESSFUL';
    case CANCELED = 'CANCELED';
}
