<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\SumUp;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpConfigurationException;

class SumUpTest extends TestCase
{
    public function testCanCreateWithApiKey()
    {
        $sumup = new SumUp([
            'api_key' => 'secret-api-key',
        ]);

        $token = $sumup->getDefaultAccessToken();
        $this->assertInstanceOf(AccessToken::class, $token);
        $this->assertSame('secret-api-key', $token->getValue());
        $this->assertSame('Bearer', $token->getType());
    }

    public function testCanCreateWithAccessToken()
    {
        $sumup = new SumUp([
            'access_token' => 'access-token-value',
        ]);

        $token = $sumup->getDefaultAccessToken();
        $this->assertInstanceOf(AccessToken::class, $token);
        $this->assertSame('access-token-value', $token->getValue());
        $this->assertSame('Bearer', $token->getType());
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
        $this->assertInstanceOf(AccessToken::class, $token);
        $this->assertSame('new-token', $token->getValue());
        $this->assertSame('Bearer', $token->getType());
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
