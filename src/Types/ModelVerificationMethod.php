<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Verification method used for the transaction.
 */
enum ModelVerificationMethod: string
{
    case NONE = 'none';
    case NA = 'na';
    case SIGNATURE = 'signature';
    case OFFLINE_PIN = 'offline PIN';
    case ONLINE_PIN = 'online PIN';
    case OFFLINE_PIN_PLUS_SIGNATURE = 'offline PIN + signature';
    case CONFIRMATION_CODE_VERIFIED = 'confirmation code verified';
}
