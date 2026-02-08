<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Entry mode of the payment details.
 */
enum TransactionCheckoutInfoEntryMode: string
{
    case NONE = 'none';
    case MAGSTRIPE = 'magstripe';
    case CHIP = 'chip';
    case MANUAL_ENTRY = 'manual entry';
    case CUSTOMER_ENTRY = 'customer entry';
    case MAGSTRIPE_FALLBACK = 'magstripe fallback';
    case CONTACTLESS = 'contactless';
    case MOTO = 'moto';
    case CONTACTLESS_MAGSTRIPE = 'contactless magstripe';
    case BOLETO = 'boleto';
    case DIRECT_DEBIT = 'direct debit';
    case SOFORT = 'sofort';
    case IDEAL = 'ideal';
    case BANCONTACT = 'bancontact';
    case EPS = 'eps';
    case MYBANK = 'mybank';
    case SATISPAY = 'satispay';
    case BLIK = 'blik';
    case P_24 = 'p24';
    case GIROPAY = 'giropay';
    case PIX = 'pix';
    case QR_CODE_PIX = 'qr code pix';
    case APPLE_PAY = 'apple pay';
    case GOOGLE_PAY = 'google pay';
    case PAYPAL = 'paypal';
    case NA = 'na';
}
