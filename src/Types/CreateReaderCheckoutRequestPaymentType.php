<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * The payment method type for the transaction. Defaults to `card`.
 *
 * Use `pix` to initiate a Pix QR-code payment flow on the device.
 * Pix is only supported for Brazilian merchants; other merchants will receive a 422 error.
 *
 */
enum CreateReaderCheckoutRequestPaymentType: string
{
    case CARD = 'card';
    case PIX = 'pix';
}
