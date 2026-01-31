<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\SumUp;

class SumUpTest extends TestCase
{
    private $originalApiKey;
    private $originalAccessToken;

    protected function setUp(): void
    {
        $this->originalApiKey = getenv('SUMUP_API_KEY');
        $this->originalAccessToken = getenv('SUMUP_ACCESS_TOKEN');
        putenv('SUMUP_API_KEY');
        putenv('SUMUP_ACCESS_TOKEN');
    }

    protected function tearDown(): void
    {
        if ($this->originalApiKey !== false && $this->originalApiKey !== null) {
            putenv('SUMUP_API_KEY=' . $this->originalApiKey);
        } else {
            putenv('SUMUP_API_KEY');
        }

        if ($this->originalAccessToken !== false && $this->originalAccessToken !== null) {
            putenv('SUMUP_ACCESS_TOKEN=' . $this->originalAccessToken);
        } else {
            putenv('SUMUP_ACCESS_TOKEN');
        }
    }

    public function testCanCreateWithApiKey()
    {
        $sumup = new SumUp('secret-api-key');

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



    public function testPropertyAccessUsesDefaultToken()
    {
        $sumup = new SumUp('test-key');

        $checkouts = $sumup->checkouts;
        $this->assertInstanceOf(\SumUp\Services\Checkouts::class, $checkouts);
    }
}
