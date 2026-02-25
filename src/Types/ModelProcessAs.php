<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Debit/Credit.
 */
enum ModelProcessAs: string
{
    case CREDIT = 'CREDIT';
    case DEBIT = 'DEBIT';
}
