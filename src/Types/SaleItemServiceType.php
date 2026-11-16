<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The type of service for this line.
 */
enum SaleItemServiceType: string
{
    case IN_HOUSE = 'IN_HOUSE';
    case TAKE_AWAY = 'TAKE_AWAY';
}
