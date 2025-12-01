<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\SumUp;
use SumUp\Exceptions\SumUpConfigurationException;

class SumUpTest extends TestCase
{
    public function testCanCreateWithApiKey()
    {
        $sumup = new SumUp([
            'api_key' => 'secret-api-key',
        ]);

        $token = $sumup->getDefaultAccessToken();
        $this->assertIsString($token);
        $this->assertSame('secret-api-key', $token);
    }

    public function testCanCreateWithAccessToken()
    {
        $sumup = new SumUp([
            'access_token' => 'access-token-value',
        ]);

        $token = $sumup->getDefaultAccessToken();
        $this->assertIsString($token);
        $this->assertSame('access-token-value', $token);
    }

    public function testCanCreateWithoutToken()
    {
        $sumup = new SumUp();

        $this->assertNull($sumup->getDefaultAccessToken());
    }

    public function testCanSetDefaultAccessToken()
    {
        $sumup = new SumUp();
        $sumup->setDefaultAccessToken('new-token');

        $token = $sumup->getDefaultAccessToken();
        $this->assertIsString($token);
        $this->assertSame('new-token', $token);
    }



    public function testGetServiceWithDefaultToken()
    {
        $sumup = new SumUp([
            'api_key' => 'test-key',
        ]);

        $checkouts = $sumup->getService('checkouts');
        $this->assertInstanceOf(\SumUp\Services\Checkouts::class, $checkouts);
    }

    public function testGetServiceWithOverrideToken()
    {
        $sumup = new SumUp([
            'api_key' => 'test-key',
        ]);

        $checkouts = $sumup->getService('checkouts', 'override-token');
        $this->assertInstanceOf(\SumUp\Services\Checkouts::class, $checkouts);
    }

    public function testGetServiceThrowsExceptionWhenNoTokenAvailable()
    {
        $sumup = new SumUp();

        $this->expectException(SumUpConfigurationException::class);
        $this->expectExceptionMessage('No access token provided');
        
        $sumup->getService('checkouts');
    }

    public function testPropertyAccessUsesDefaultToken()
    {
        $sumup = new SumUp([
            'api_key' => 'test-key',
        ]);

        $checkouts = $sumup->checkouts;
        $this->assertInstanceOf(\SumUp\Services\Checkouts::class, $checkouts);
    }
}
