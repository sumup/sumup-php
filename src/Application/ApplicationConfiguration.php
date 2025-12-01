<?php

namespace SumUp\Application;

use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\SdkInfo;

/**
 * Class ApplicationConfiguration
 *
 * @package SumUp\ApplicationConfiguration
 */
class ApplicationConfiguration implements ApplicationConfigurationInterface
{
    /**
     * Header name for the SDK's User-Agent.
     */
    const USER_AGENT_HEADER = 'User-Agent';

    /**
     * The base URL of the SumUp API.
     *
     * @var string;
     */
    protected $baseURL;

    /**
     * The access token.
     *
     * @var null|string
     */
    protected $accessToken;

    /**
     * Custom headers to be sent with every request.
     *
     * @var array $customHeaders
     */
    protected $customHeaders;

    /**
     * Path to a custom CA bundle. If not provided, the SDK ships one by default.
     *
     * @var string|null
     */
    protected $caBundlePath;

    /**
     * The API key for authentication.
     *
     * @var string|null
     */
    protected $apiKey;

    /**
     * Create a new application configuration.
     *
     * @param array $config
     *
     * @throws SumUpConfigurationException
     */
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'api_key' => null,
            'access_token' => null,
            'base_uri' => 'https://api.sumup.com',
            'custom_headers' => [],
            'ca_bundle_path' => null
        ], $config);

        $this->apiKey = $config['api_key'] ?? getenv('SUMUP_API_KEY') ?: null;
        $this->accessToken = $config['access_token'];
        $this->baseURL = $config['base_uri'];
        $this->setCustomHeaders($config['custom_headers']);
        $this->setCABundlePath($config['ca_bundle_path']);
    }

    /**
     * Returns the base URL of the SumUp API.
     *
     * @return string
     */
    public function getBaseURL()
    {
        return $this->baseURL;
    }

    /**
     * Returns initial access token.
     *
     * @return null|string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Returns associative array with custom headers.
     *
     * @return array
     */
    public function getCustomHeaders()
    {
        return $this->customHeaders;
    }

    /**
     * Returns the path to the CA bundle used for HTTPS verification.
     *
     * @return string|null
     */
    public function getCABundlePath()
    {
        if (!empty($this->caBundlePath)) {
            return $this->caBundlePath;
        }

        return $this->getDefaultCABundlePath();
    }

    /**
     * Returns the API key if set.
     *
     * @return string|null
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the associative array with custom headers.
     *
     * @param array $customHeaders
     */
    public function setCustomHeaders($customHeaders)
    {
        $headers = is_array($customHeaders) ? $customHeaders : [];
        $headers[self::USER_AGENT_HEADER] = SdkInfo::getUserAgent();

        $this->customHeaders = $headers;
    }

    /**
     * Set the CA bundle path used for TLS verification.
     *
     * @param string|null $caBundlePath
     *
     * @throws SumUpConfigurationException
     */
    protected function setCABundlePath($caBundlePath)
    {
        if ($caBundlePath === null || $caBundlePath === '') {
            $this->caBundlePath = null;
            return;
        }

        if (!is_string($caBundlePath)) {
            throw new SumUpConfigurationException('Invalid value for "ca_bundle_path". Expected string path or null.');
        }

        if (!is_readable($caBundlePath)) {
            throw new SumUpConfigurationException(sprintf('The provided ca_bundle_path "%s" is not readable.', $caBundlePath));
        }

        $this->caBundlePath = $caBundlePath;
    }

    /**
     * Returns the path to the CA bundle shipped with the SDK, if present.
     *
     * @return string|null
     */
    private function getDefaultCABundlePath()
    {
        $path = realpath(__DIR__ . '/../../../resources/ca-bundle.crt');
        if ($path && is_readable($path)) {
            return $path;
        }

        return null;
    }
}
