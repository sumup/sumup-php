<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The role of the user.
 */
enum AccountLegacyType: string
{
    case NORMAL = 'normal';
    case OPERATOR = 'operator';
}
