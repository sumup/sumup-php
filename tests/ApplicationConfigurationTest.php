<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Application\ApplicationConfiguration;
use SumUp\SdkInfo;

class ApplicationConfigurationTest extends TestCase
{
    public function testCanCreateWithApiKey()
    {
        $config = new ApplicationConfiguration([
            'api_key' => 'test-api-key',
        ]);

        $this->assertSame('test-api-key', $config->getApiKey());
    }

    public function testCanCreateWithAccessToken()
    {
        $config = new ApplicationConfiguration([
            'access_token' => 'test-access-token',
        ]);

        $this->assertSame('test-access-token', $config->getAccessToken());
    }

    public function testFallsBackToEnvVariableWhenNoApiKeyProvided()
    {
        putenv('SUMUP_API_KEY=env-api-key');
        
        $config = new ApplicationConfiguration([]);
        
        $this->assertSame('env-api-key', $config->getApiKey());
        
        putenv('SUMUP_API_KEY');
    }

    public function testProvidedApiKeyTakesPrecedenceOverEnvVariable()
    {
        putenv('SUMUP_API_KEY=env-api-key');
        
        $config = new ApplicationConfiguration([
            'api_key' => 'config-api-key',
        ]);
        
        $this->assertSame('config-api-key', $config->getApiKey());
        
        putenv('SUMUP_API_KEY');
    }



    public function testUserAgentHeaderIsAlwaysAdded()
    {
        $config = new ApplicationConfiguration([
            'api_key' => 'test-api-key',
        ]);

        $headers = $config->getCustomHeaders();

        $this->assertArrayHasKey(ApplicationConfiguration::USER_AGENT_HEADER, $headers);
        $this->assertSame(SdkInfo::getUserAgent(), $headers[ApplicationConfiguration::USER_AGENT_HEADER]);
    }

    public function testCustomUserAgentHeaderIsOverridden()
    {
        $config = new ApplicationConfiguration([
            'api_key' => 'test-api-key',
            'custom_headers' => [
                'User-Agent' => 'custom-agent',
                'X-Custom' => 'value',
            ],
        ]);

        $headers = $config->getCustomHeaders();

        $this->assertSame(SdkInfo::getUserAgent(), $headers[ApplicationConfiguration::USER_AGENT_HEADER]);
        $this->assertSame('value', $headers['X-Custom']);
    }
}
