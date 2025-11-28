<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
use SumUp\Application\ApplicationConfigurationInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\HttpClients\HttpClientsFactory;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Services\Authorization;
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
     * The access token that holds the data from the response.
     *
     * @var AccessToken
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
    public function __construct(array $config = [], SumUpHttpClientInterface $customHttpClient = null)
    {
        $this->appConfig = new ApplicationConfiguration($config);
        $this->client = HttpClientsFactory::createHttpClient($this->appConfig, $customHttpClient);
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->getToken();
    }

    /**
     * Returns the access token.
     *
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Refresh the access token.
     *
     * @param string $refreshToken
     *
     * @return AccessToken
     *
     * @throws SumUpSDKException
     */
    public function refreshToken($refreshToken = null)
    {
        if (isset($refreshToken)) {
            $rToken = $refreshToken;
        } elseif (!isset($refreshToken) && !isset($this->accessToken)) {
            throw new SumUpConfigurationException('There is no refresh token');
        } else {
            $rToken = $this->accessToken->getRefreshToken();
        }
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->refreshToken($rToken);
        return $this->accessToken;
    }

    /**
     * Get the service for authorization.
     *
     * @param ApplicationConfigurationInterface|null $config
     *
     * @return Authorization
     */
    public function getAuthorizationService(ApplicationConfigurationInterface $config = null)
    {
        if (empty($config)) {
            $cfg = $this->appConfig;
        } else {
            $cfg = $config;
        }
        return new Authorization($this->client, $cfg);
    }

    /**
     * Resolve the access token that should be used for a service.
     *
     * @param AccessToken|null $accessToken
     *
     * @return AccessToken
     */
    protected function resolveAccessToken(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            return $accessToken;
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
     * @param AccessToken|null $accessToken
     *
     * @return SumUpService|null
     */
    public function getService($name, AccessToken $accessToken = null)
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
     * @param AccessToken|null $accessToken
     *
     * @return Custom
     */
    public function getCustomService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Custom($this->client, $token);
    }
}
