<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Current status of the checkout.
 */
enum CheckoutCreateRequestStatus: string
{
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case PAID = 'PAID';
}
