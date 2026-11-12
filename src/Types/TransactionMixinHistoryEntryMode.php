<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * How the payment details were captured, for example `chip` or `contactless` for card-present payments and `customer entry` for card details entered by the payer. For wallet and alternative payment methods, this can identify the method, such as `apple pay` or `blik`.
 */
enum TransactionMixinHistoryEntryMode: string
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
    case SUMUP_GIFT_CARD = 'sumup gift card';
    case PAYPAL = 'paypal';
    case TWINT = 'twint';
    case IRIS = 'iris';
    case SUMUP_PAY = 'sumup pay';
    case NA = 'na';
}
