<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Current status of the checkout.
 */
enum CheckoutStatus: string
{
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case PAID = 'PAID';
    case EXPIRED = 'EXPIRED';
}
