<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Type of the card, or null when no card type was specified.
 */
enum GetReaderCheckoutResponseDataCardType: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
    case NULL = 'null';
}
