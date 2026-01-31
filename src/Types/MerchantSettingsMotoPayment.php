<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Whether merchant can make MOTO payments
 */
enum MerchantSettingsMotoPayment: string
{
    case UNAVAILABLE = 'UNAVAILABLE';
    case ENFORCED = 'ENFORCED';
    case ON = 'ON';
    case OFF = 'OFF';
}
