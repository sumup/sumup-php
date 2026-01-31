<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Payment type used for the transaction.
 */
enum TransactionBasePaymentType: string
{
    case CASH = 'CASH';
    case POS = 'POS';
    case ECOM = 'ECOM';
    case RECURRING = 'RECURRING';
    case BITCOIN = 'BITCOIN';
    case BALANCE = 'BALANCE';
    case MOTO = 'MOTO';
    case BOLETO = 'BOLETO';
    case DIRECT_DEBIT = 'DIRECT_DEBIT';
    case APM = 'APM';
    case UNKNOWN = 'UNKNOWN';
}
