<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Issuing card network of the payment card used for the transaction.
 */
enum CardResponseType: string
{
    case AMEX = 'AMEX';
    case CUP = 'CUP';
    case DINERS = 'DINERS';
    case DISCOVER = 'DISCOVER';
    case ELO = 'ELO';
    case ELV = 'ELV';
    case HIPERCARD = 'HIPERCARD';
    case JCB = 'JCB';
    case MAESTRO = 'MAESTRO';
    case MASTERCARD = 'MASTERCARD';
    case VISA = 'VISA';
    case VISA_ELECTRON = 'VISA_ELECTRON';
    case VISA_VPAY = 'VISA_VPAY';
    case UNKNOWN = 'UNKNOWN';
}
