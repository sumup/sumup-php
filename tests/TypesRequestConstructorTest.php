<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SumUp\Types\CheckoutCreateRequest;
use SumUp\Types\CheckoutCreateRequestCurrency;
use SumUp\Types\CreateReaderCheckoutRequest;
use SumUp\Types\CreateReaderCheckoutRequestAade;
use SumUp\Types\CreateReaderCheckoutRequestAffiliate;
use SumUp\Types\CreateReaderCheckoutRequestTotalAmount;

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

    public function testCreateReaderCheckoutRequestHydratesInlineObjectProperties(): void
    {
        $request = new CreateReaderCheckoutRequest([
            'aade' => [
                'provider_id' => 'provider-123',
                'signature' => 'base64-signature',
                'signature_data' => 'signed-data',
            ],
            'affiliate' => [
                'app_id' => 'com.example.app',
                'foreign_transaction_id' => 'txn-123',
                'key' => 'key-123',
                'tags' => [
                    'source' => 'sdk-test',
                ],
            ],
            'total_amount' => [
                'currency' => 'EUR',
                'minor_unit' => 2,
                'value' => 100,
            ],
        ]);

        $this->assertInstanceOf(CreateReaderCheckoutRequestAade::class, $request->aade);
        $this->assertSame('provider-123', $request->aade->providerId);
        $this->assertSame('signed-data', $request->aade->signatureData);

        $this->assertInstanceOf(CreateReaderCheckoutRequestAffiliate::class, $request->affiliate);
        $this->assertSame('com.example.app', $request->affiliate->appId);
        $this->assertSame(['source' => 'sdk-test'], $request->affiliate->tags);

        $this->assertInstanceOf(CreateReaderCheckoutRequestTotalAmount::class, $request->totalAmount);
        $this->assertSame('EUR', $request->totalAmount->currency);
        $this->assertSame(2, $request->totalAmount->minorUnit);
        $this->assertSame(100, $request->totalAmount->value);
    }
}
