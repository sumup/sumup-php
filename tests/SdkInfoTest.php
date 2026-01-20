<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\ApiVersion;
use SumUp\SdkInfo;
use SumUp\Utils\Headers;

class SdkInfoTest extends TestCase
{
    public function testStandardHeadersIncludeRuntimeMetadata()
    {
        $headers = Headers::getStandardHeaders();

        $this->assertSame('application/json', $headers['Content-Type']);
        $this->assertSame(SdkInfo::getUserAgent(), $headers['User-Agent']);
        $this->assertSame(ApiVersion::CURRENT, $headers['X-Sumup-Api-Version']);
        $this->assertSame('php', $headers['X-Sumup-Lang']);
        $this->assertSame(SdkInfo::getVersion(), $headers['X-Sumup-Package-Version']);
        $this->assertSame('php', $headers['X-Sumup-Runtime']);
        $this->assertSame(PHP_VERSION, $headers['X-Sumup-Runtime-Version']);
        $this->assertNotSame('', $headers['X-Sumup-Os']);
        $this->assertNotSame('', $headers['X-Sumup-Arch']);
    }

    public function testRuntimeHeadersAreStableBetweenCalls()
    {
        $this->assertSame(SdkInfo::getRuntimeHeaders(), SdkInfo::getRuntimeHeaders());
    }
}
