<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Hydrator;
use SumUp\Types\Checkout;
use SumUp\Types\CheckoutCurrency;

class HydratorTest extends TestCase
{
    public function testHydrateBackedEnumPropertyFromScalarValue()
    {
        $checkout = Hydrator::hydrate([
            'currency' => 'EUR',
        ], Checkout::class);

        $this->assertInstanceOf(Checkout::class, $checkout);
        $this->assertSame(CheckoutCurrency::EUR, $checkout->currency);
    }
}
