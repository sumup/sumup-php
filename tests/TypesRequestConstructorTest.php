<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SumUp\Types\CheckoutCreateRequest;
use SumUp\Types\CheckoutCreateRequestCurrency;

class TypesRequestConstructorTest extends TestCase
{
    public function testCheckoutCreateRequestSupportsArrayInputWithEnumCoercion(): void
    {
        $request = new CheckoutCreateRequest([
            'checkout_reference' => 'ref-123',
            'amount' => 10,
            'currency' => 'EUR',
            'merchant_code' => 'MERCHANT-1',
        ]);

        $this->assertSame('ref-123', $request->checkoutReference);
        $this->assertSame(10.0, $request->amount);
        $this->assertSame(CheckoutCreateRequestCurrency::EUR, $request->currency);
        $this->assertSame('MERCHANT-1', $request->merchantCode);
    }

    public function testCheckoutCreateRequestIgnoresUnknownProperty(): void
    {
        $request = new CheckoutCreateRequest([
            'checkout_reference' => 'ref-123',
            'amount' => 10.0,
            'currency' => CheckoutCreateRequestCurrency::EUR,
            'merchant_code' => 'MERCHANT-1',
            'not_a_field' => true,
        ]);

        $this->assertSame('ref-123', $request->checkoutReference);
    }

    public function testCheckoutCreateRequestAllowsPartialInput(): void
    {
        $request = new CheckoutCreateRequest([
            'checkout_reference' => 'ref-123',
        ]);

        $this->assertSame('ref-123', $request->checkoutReference);
    }
}
