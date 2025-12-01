<?php

namespace SumUp\HttpClients;

use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Application\ApplicationConfigurationInterface;

/**
 * Class HttpClientsFactory
 *
 * @package SumUp\HttpClients
 */
class HttpClientsFactory
{
    private function __construct()
    {
        // a factory constructor should never be invoked
    }

    /**
     * Create the HTTP client needed for communication with the SumUp's servers.
     *
     * @param ApplicationConfigurationInterface $appConfig
     * @param SumUpHttpClientInterface|null $customHttpClient
     *
     * @return SumUpHttpClientInterface
     *
     * @throws SumUpConfigurationException
     */
    public static function createHttpClient(ApplicationConfigurationInterface $appConfig, ?SumUpHttpClientInterface $customHttpClient = null)
    {
        if ($customHttpClient) {
            return $customHttpClient;
        }
        return self::detectDefaultClient(
            $appConfig->getBaseURL(),
            $appConfig->getCustomHeaders(),
            $appConfig->getCABundlePath()
        );
    }

    /**
     * Detect the default HTTP client.
     *
     * @param string $baseURL
     * @param array $customHeaders
     * @param string|null $caBundlePath
     *
     * @return SumUpCUrlClient
     *
     * @throws SumUpConfigurationException
     */
    private static function detectDefaultClient($baseURL, $customHeaders, $caBundlePath)
    {
        if (!extension_loaded('curl')) {
            throw new SumUpConfigurationException('cURL extension is required. Please install the cURL extension or provide a custom HTTP client.');
        }

        return new SumUpCUrlClient($baseURL, $customHeaders, $caBundlePath);
    }
}
