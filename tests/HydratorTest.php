<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Hydrator;
use SumUp\Types\Checkout;
use SumUp\Types\CheckoutCurrency;
use SumUp\Types\CardResponseType;
use SumUp\Types\MandateResponse;
use SumUp\Types\MandateResponseStatus;
use SumUp\Types\Receipt;

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

    public function testHydrateBackedEnumPropertyFromEnumInstance()
    {
        $checkout = Hydrator::hydrate([
            'currency' => CheckoutCurrency::USD,
        ], Checkout::class);

        $this->assertInstanceOf(Checkout::class, $checkout);
        $this->assertSame(CheckoutCurrency::USD, $checkout->currency);
    }

    public function testHydrateNestedObjectWithNormalizedPropertyNames()
    {
        $checkout = Hydrator::hydrate([
            'mandate' => [
                'merchant_code' => 'MC123',
                'status' => 'active',
            ],
        ], Checkout::class);

        $this->assertInstanceOf(Checkout::class, $checkout);
        $this->assertInstanceOf(MandateResponse::class, $checkout->mandate);
        $this->assertSame('MC123', $checkout->mandate->merchantCode);
        $this->assertSame(MandateResponseStatus::ACTIVE, $checkout->mandate->status);
    }

    public function testHydrateOpaqueObjectSchemaAsArray()
    {
        $receipt = Hydrator::hydrate([
            'emv_data' => [
                'application' => [
                    'identifier' => 'A0000000031010',
                ],
            ],
        ], Receipt::class);

        $this->assertInstanceOf(Receipt::class, $receipt);
        $this->assertIsArray($receipt->emvData);
        $this->assertSame('A0000000031010', $receipt->emvData['application']['identifier']);
    }

    public function testHydrateArrayItemsFromDocblockClassNames()
    {
        $response = Hydrator::hydrate([
            'links' => [
                ['href' => 'https://example.test/1'],
                ['href' => 'https://example.test/2'],
            ],
        ], HydratorArrayFixture::class);

        $this->assertInstanceOf(HydratorArrayFixture::class, $response);
        $this->assertCount(2, $response->links);
        $this->assertInstanceOf(HydratorLinkFixture::class, $response->links[0]);
        $this->assertInstanceOf(HydratorLinkFixture::class, $response->links[1]);
        $this->assertSame('https://example.test/1', $response->links[0]->href);
        $this->assertSame('https://example.test/2', $response->links[1]->href);
    }

    public function testHydrateUnknownBackedEnumValuePreservesScalar()
    {
        $checkout = Hydrator::hydrate([
            'currency' => 'FUTURE_CURRENCY',
        ], Checkout::class);

        $this->assertSame('FUTURE_CURRENCY', $checkout->currency);
    }

    public function testHydrateNullEnumProperty()
    {
        $checkout = Hydrator::hydrate(['currency' => null], Checkout::class);

        $this->assertNull($checkout->currency);
    }

    public function testHydrateArrayOfOpenEnums()
    {
        $response = Hydrator::hydrate([
            'types' => ['known' => 'VISA', 'instance' => CardResponseType::AMEX, 'new' => 'FUTURE_CARD'],
        ], HydratorEnumArrayFixture::class);

        $this->assertSame([
            'known' => CardResponseType::VISA,
            'instance' => CardResponseType::AMEX,
            'new' => 'FUTURE_CARD',
        ], $response->types);
    }
}

class HydratorArrayFixture
{
    /**
     * @var HydratorLinkFixture[]|null
     */
    public ?array $links = null;
}

class HydratorLinkFixture
{
    /**
     * @var string|null
     */
    public ?string $href = null;
}

class HydratorEnumArrayFixture
{
    /**
     * @var \SumUp\Types\CardResponseType[]|string[]|null
     */
    public ?array $types = null;
}
