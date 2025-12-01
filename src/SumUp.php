<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\HttpClients\HttpClientsFactory;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Services\Checkouts;
use SumUp\Services\Custom;
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
     * The application's configuration.
     *
     * @var ApplicationConfiguration
     */
    protected $appConfig;

    /**
     * The default access token.
     *
     * @var AccessToken|null
     */
    protected $defaultAccessToken;

    /**
     * @var SumUpHttpClientInterface
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
     * @param array $config
     * @param SumUpHttpClientInterface|null $customHttpClient
     *
     * @throws SumUpSDKException
     */
    public function __construct(array $config = [], ?SumUpHttpClientInterface $customHttpClient = null)
    {
        $this->appConfig = new ApplicationConfiguration($config);
        $this->client = HttpClientsFactory::createHttpClient($this->appConfig, $customHttpClient);
        
        // Create default access token from config
        if (!empty($this->appConfig->getApiKey())) {
            $this->defaultAccessToken = new AccessToken($this->appConfig->getApiKey(), 'Bearer');
        } elseif (!empty($this->appConfig->getAccessToken())) {
            $this->defaultAccessToken = new AccessToken($this->appConfig->getAccessToken(), 'Bearer');
        }
    }

    /**
     * Returns the default access token.
     *
     * @return AccessToken|null
     */
    public function getDefaultAccessToken()
    {
        return $this->defaultAccessToken;
    }

    /**
     * Set a new default access token.
     *
     * @param string $token
     * @param string $type
     *
     * @return void
     */
    public function setDefaultAccessToken($token, $type = 'Bearer')
    {
        $this->defaultAccessToken = new AccessToken($token, $type);
    }

    /**
     * Resolve the access token that should be used for a service.
     *
     * @param AccessToken|string|null $accessToken
     *
     * @return AccessToken|null
     *
     * @throws SumUpConfigurationException
     */
    protected function resolveAccessToken($accessToken = null)
    {
        if ($accessToken instanceof AccessToken) {
            return $accessToken;
        }
        
        if (is_string($accessToken)) {
            return new AccessToken($accessToken, 'Bearer');
        }
        
        if (!empty($accessToken)) {
            throw new SumUpConfigurationException('Access token must be a string or AccessToken instance');
        }

        if (!empty($this->defaultAccessToken)) {
            return $this->defaultAccessToken;
        }
        
        throw new SumUpConfigurationException('No access token provided. Please provide a token via constructor configuration, setDefaultAccessToken(), or pass one to the service method.');
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
        return $this->getService($name);
    }

    /**
     * Resolve a service by its property name.
     *
     * @param string $name
     * @param AccessToken|string|null $accessToken
     *
     * @return SumUpService|null
     */
    public function getService($name, $accessToken = null)
    {
        if (!array_key_exists($name, self::$serviceClassMap)) {
            trigger_error('Undefined property: ' . static::class . '::$' . $name);

            return null;
        }

        $token = $this->resolveAccessToken($accessToken);
        $serviceClass = self::$serviceClassMap[$name];

        return new $serviceClass($this->client, $token);
    }

    /**
     * @param AccessToken|string|null $accessToken
     *
     * @return Custom
     */
    public function getCustomService($accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Custom($this->client, $token);
    }
}
