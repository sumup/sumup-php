<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Lifecycle state of the sale.
 * Non-finalised sales are never returned; only fully-paid sales.
 */
enum SaleSearchItemState: string
{
    case CLOSED = 'CLOSED';
}
