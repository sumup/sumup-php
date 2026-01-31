<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Simple name of the payment type.
 */
enum ModelSimplePaymentType: string
{
    case MOTO = 'MOTO';
    case CASH = 'CASH';
    case CC_SIGNATURE = 'CC_SIGNATURE';
    case ELV = 'ELV';
    case CC_CUSTOMER_ENTERED = 'CC_CUSTOMER_ENTERED';
    case MANUAL_ENTRY = 'MANUAL_ENTRY';
    case EMV = 'EMV';
}
