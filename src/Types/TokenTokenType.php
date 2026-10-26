<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Authentication scheme used by the token. Always Bearer.
 */
enum TokenTokenType: string
{
    case BEARER = 'Bearer';
}
