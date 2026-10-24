<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Key indicating type of error
 */
enum BadRequestErrorsType: string
{
    case INVALID_AFFILIATE_KEY = 'INVALID_AFFILIATE_KEY';
    case APP_OUTDATED = 'APP_OUTDATED';
    case INVALID_BEARER_TOKEN = 'INVALID_BEARER_TOKEN';
    case INVALID_USER_AGENT = 'INVALID_USER_AGENT';
    case NOT_ENOUGH_UNPAID_PAYOUTS = 'NOT_ENOUGH_UNPAID_PAYOUTS';
    case DUPLICATE_HEADERS = 'DUPLICATE_HEADERS';
}
