<?php

namespace SumUp;

use SumUp\Exception\ConfigurationException;
use SumUp\Exception\SDKException;
use SumUp\HttpClient\CurlClient;
use SumUp\HttpClient\HttpClientInterface;
use SumUp\Services\Checkouts;
use SumUp\Services\Customers;
use SumUp\Services\Members;
use SumUp\Services\Memberships;
use SumUp\Services\Merchant;
use SumUp\Services\Merchants;
use SumUp\Services\Payouts;
use SumUp\Services\Readers;
use SumUp\Services\Receipts;
use SumUp\Services\Roles;
use SumUp\Services\Subaccounts;
use SumUp\Services\SumUpService;
use SumUp\Services\Transactions;

/**
 * Class SumUp
 *
 * @package SumUp
 *
 * @property Checkouts $checkouts
 * @property Customers $customers
 * @property Members $members
 * @property Memberships $memberships
 * @property Merchant $merchant
 * @property Merchants $merchants
 * @property Payouts $payouts
 * @property Readers $readers
 * @property Receipts $receipts
 * @property Roles $roles
 * @property Subaccounts $subaccounts
 * @property Transactions $transactions
 */
class SumUp
{
    /**
     * The access token for API authentication.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * Map of property names to service classes.
     *
     * @var array<string, string>
     */
    private static $serviceClassMap = [
        'checkouts' => Checkouts::class,
        'customers' => Customers::class,
        'members' => Members::class,
        'memberships' => Memberships::class,
        'merchant' => Merchant::class,
        'merchants' => Merchants::class,
        'payouts' => Payouts::class,
        'readers' => Readers::class,
        'receipts' => Receipts::class,
        'roles' => Roles::class,
        'subaccounts' => Subaccounts::class,
        'transactions' => Transactions::class,
    ];



    /**
     * SumUp constructor.
     *
     * @param string|array|null $configOrApiKey
     *
     * @throws SDKException
     */
    public function __construct($configOrApiKey = null)
    {
        $config = [];
        if (is_string($configOrApiKey) && $configOrApiKey !== '') {
            $config['api_key'] = $configOrApiKey;
        } elseif (is_array($configOrApiKey)) {
            $config = $configOrApiKey;
        }
        $customHttpClient = $config['client'] ?? null;
        if (array_key_exists('client', $config)) {
            unset($config['client']);
        }

        $config = $this->normalizeConfig($config);
        if ($customHttpClient instanceof HttpClientInterface) {
            $this->client = $customHttpClient;
        } else {
            $this->client = new CurlClient(
                $config['base_uri'],
                $config['custom_headers'],
                $config['ca_bundle_path']
            );
        }
        
        // Set access token from config (api_key or access_token)
        if (!empty($config['api_key'])) {
            $this->accessToken = $config['api_key'];
        } elseif (!empty($config['access_token'])) {
            $this->accessToken = $config['access_token'];
        }
    }

    /**
     * Returns the default access token.
     *
     * @return string|null
     */
    public function getDefaultAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Sets the default access token.
     *
     * @param string $accessToken
     *
     * @return void
     */
    public function setDefaultAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Resolve the access token that should be used for a service.
     *
     * @param string|null $accessToken
     *
     * @return string
     *
     * @throws ConfigurationException
     */
    protected function resolveAccessToken($accessToken = null)
    {
        if (!empty($accessToken)) {
            return $accessToken;
        }

        if (empty($this->accessToken)) {
            throw new ConfigurationException('No access token provided');
        }

        return $this->accessToken;
    }

    /**
     * Normalize configuration and apply defaults.
     *
     * @param array $config
     *
     * @return array
     *
     * @throws ConfigurationException
     */
    private function normalizeConfig(array $config)
    {
        $config = array_merge([
            'api_key' => null,
            'access_token' => null,
            'base_uri' => 'https://api.sumup.com',
            'custom_headers' => [],
            'ca_bundle_path' => null,
        ], $config);

        if ($config['api_key'] === null) {
            $config['api_key'] = getenv('SUMUP_API_KEY') ?: null;
        }

        if ($config['access_token'] === null) {
            $config['access_token'] = getenv('SUMUP_ACCESS_TOKEN') ?: null;
        }

        $headers = is_array($config['custom_headers']) ? $config['custom_headers'] : [];
        $headers['User-Agent'] = SdkInfo::getUserAgent();
        $config['custom_headers'] = $headers;

        return $config;
    }

    /**
     * Proxy access to services via properties.
     *
     * @param string $name
     *
     * @return SumUpService|null
     */
    public function __get($name)
    {
        if (!array_key_exists($name, self::$serviceClassMap)) {
            trigger_error('Undefined property: ' . static::class . '::$' . $name);

            return null;
        }

        $token = $this->resolveAccessToken();
        $serviceClass = self::$serviceClassMap[$name];

        return new $serviceClass($this->client, $token);
    }

}
