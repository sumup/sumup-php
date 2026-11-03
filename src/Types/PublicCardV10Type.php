<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Credit or debit processing choice, not brand or funding.
 * `unknown` when unavailable; prepaid/voucher are not processing types.
 */
enum PublicCardV10Type: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
    case UNKNOWN = 'unknown';
}
