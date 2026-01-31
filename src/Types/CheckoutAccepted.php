<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * 3DS Response
 */
class CheckoutAccepted
{
    /**
     * Required action processing 3D Secure payments.
     *
     * @var array|null
     */
    public ?array $nextStep = null;

}
