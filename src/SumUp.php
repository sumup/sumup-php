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
use SumUp\Services\Merchants;
use SumUp\Services\Payouts;
use SumUp\Services\Readers;
use SumUp\Services\Receipts;
use SumUp\Services\Roles;
use SumUp\Services\Subaccounts;
use SumUp\Services\Transactions;

/**
 * Class SumUp
 *
 * @package SumUp
 *
 */
class SumUp
{
    /**
     * The access token for API authentication.
     *
     * @var string|null
     */
    protected ?string $accessToken = null;

    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $client;

    /**
     * SumUp constructor.
     *
     * @param string|array<string, mixed>|null $configOrApiKey
     *
     * @throws SDKException
     */
    public function __construct(string|array|null $configOrApiKey = null)
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
    public function getDefaultAccessToken(): ?string
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
    public function setDefaultAccessToken(string $accessToken): void
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
    protected function resolveAccessToken(?string $accessToken = null): string
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
     * @param array<string, mixed> $config
     *
     * @return array<string, mixed>
     *
     * @throws ConfigurationException
     */
    private function normalizeConfig(array $config): array
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
        $headers['Accept'] = 'application/problem+json, application/json';
        $headers['User-Agent'] = SdkInfo::getUserAgent();
        $config['custom_headers'] = $headers;

        return $config;
    }

    public function checkouts(): Checkouts
    {
        return new Checkouts($this->client, $this->resolveAccessToken());
    }

    public function customers(): Customers
    {
        return new Customers($this->client, $this->resolveAccessToken());
    }

    public function members(): Members
    {
        return new Members($this->client, $this->resolveAccessToken());
    }

    public function memberships(): Memberships
    {
        return new Memberships($this->client, $this->resolveAccessToken());
    }

    public function merchants(): Merchants
    {
        return new Merchants($this->client, $this->resolveAccessToken());
    }

    public function payouts(): Payouts
    {
        return new Payouts($this->client, $this->resolveAccessToken());
    }

    public function readers(): Readers
    {
        return new Readers($this->client, $this->resolveAccessToken());
    }

    public function receipts(): Receipts
    {
        return new Receipts($this->client, $this->resolveAccessToken());
    }

    public function roles(): Roles
    {
        return new Roles($this->client, $this->resolveAccessToken());
    }

    public function subaccounts(): Subaccounts
    {
        return new Subaccounts($this->client, $this->resolveAccessToken());
    }

    public function transactions(): Transactions
    {
        return new Transactions($this->client, $this->resolveAccessToken());
    }
}
