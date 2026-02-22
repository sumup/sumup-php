<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Purpose of the checkout.
 */
enum CheckoutCreateRequestPurpose: string
{
    case CHECKOUT = 'CHECKOUT';
    case SETUP_RECURRING_PAYMENT = 'SETUP_RECURRING_PAYMENT';
}
