<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Payment on a closed sale, for bookkeeping and reconciliation.
 *
 * Acquirer/processing cost is not on this object. Merchant-charged fees (shipping, service
 * charge, etc.) appear as `type: "FEE"` item lines in `Sale.items`.
 */
class PublicPaymentV10
{
    /**
     * Payment method on public sales read API v1.0.
     * Digital wallets are first-class methods. Gift card payments use `gift_card`, not `apm`.
     * Values use lowercase snake_case. Known values are `card`, `cash`, `apm`, `external`,
     * `apple_pay`, `google_pay`, `whatsapp_pay`, and `gift_card`.
     * Additional values may be returned as new payment methods become available.
     *
     * @var string
     */
    public string $method;

    /**
     * The reference to the actual payment used for this sale, e.g. the sumup transaction code.
     *
     * @var string
     */
    public string $reference;

    /**
     * Payment operation type.
     * This is distinct from the payment instrument in `method`.
     * Values use lowercase snake_case. Known values are `purchase` for a normal purchase
     * and `unreferenced_refund` for negative sales such as deposit returns.
     *
     * @var string
     */
    public string $type;

    /**
     * The amount of the payment including tips.
     * The value of the amount in minor units of `Sale.currency`.
     *
     * @var int
     */
    public int $amount;

    /**
     * The status of the payment.
     *
     * @var PublicPaymentV10Status
     */
    public PublicPaymentV10Status $status;

    /**
     * Alternative payment method type when `method` is `apm`.
     * Gift card is not an APM on this API.
     * Values use lowercase snake_case. Known values are `qr_code_pix`, `sepa_dd`, `paypal`,
     * `sumup_pay`, `twint`, and `iris`.
     * Additional values may be returned as new alternative payment methods become available.
     *
     * @var string|null
     */
    public ?string $apmType = null;

    /**
     * Card brand, credit/debit processing type, and last four digits.
     *
     * @var PublicCardV10|null
     */
    public ?PublicCardV10 $card = null;

    /**
     * Gift card used for this payment. Present when `method` is `gift_card` and the gift card
     * id is known.
     * Gift card IDs use the format "GC" followed by 9 alphanumeric characters
     * (e.g. GCZ3NTMB1V).
     *
     * @var PublicGiftCardPayment|null
     */
    public ?PublicGiftCardPayment $giftCard = null;

    /**
     * UTC date-time when SumUp recorded this payment’s exposed `status` (successful, failed,
     * or canceled). Server processed time when available; otherwise the payment provider’s
     * transaction time. Not the device clock.
     *
     * @var string
     */
    public string $processedAt;

}
