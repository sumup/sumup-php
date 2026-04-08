<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * Object containing token information for the specified payment instrument
 */
class CheckoutSuccessPaymentInstrument
{
    /**
     * Token value
     *
     * @var string|null
     */
    public ?string $token = null;

}
