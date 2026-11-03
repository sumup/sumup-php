<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Gift card used for this payment. Present when `method` is `gift_card` and the gift card
 * id is known.
 * Gift card IDs use the format "GC" followed by 9 alphanumeric characters
 * (e.g. GCZ3NTMB1V).
 */
class PublicGiftCardPayment
{
    /**
     * Gift card identifier. Format "GC" followed by 9 alphanumeric characters
     * (e.g. GCZ3NTMB1V).
     *
     * @var string
     */
    public string $id;

}
