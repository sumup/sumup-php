<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
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
     * The access token for API authentication.
     *
     * @var string|null
     */
    protected $accessToken;

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
        
        // Set access token from config (api_key or access_token)
        if ($this->appConfig->getApiKey()) {
            $this->accessToken = $this->appConfig->getApiKey();
        } elseif ($this->appConfig->getAccessToken()) {
            $this->accessToken = $this->appConfig->getAccessToken();
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
     * @throws SumUpConfigurationException
     */
    protected function resolveAccessToken($accessToken = null)
    {
        if (!empty($accessToken)) {
            return $accessToken;
        }

        if (empty($this->accessToken)) {
            throw new SumUpConfigurationException('No access token provided');
        }

        return $this->accessToken;
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
     * @param string|null $accessToken
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
     * @param string|null $accessToken
     *
     * @return Custom
     */
    public function getCustomService($accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Custom($this->client, $token);
    }
}
