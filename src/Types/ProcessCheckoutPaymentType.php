<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Describes the payment method used to attempt processing
 */
enum ProcessCheckoutPaymentType: string
{
    case CARD = 'card';
    case BOLETO = 'boleto';
    case IDEAL = 'ideal';
    case BLIK = 'blik';
    case BANCONTACT = 'bancontact';
}
