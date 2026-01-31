<?php

declare(strict_types=1);

namespace SumUp\Merchant;

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Merchant
 *
 * @package SumUp\Services
 */
class Merchant implements SumUpService
{
    /**
     * The client for the http communication.
     *
     * @var SumUpHttpClientInterface
     */
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Merchant constructor.
     *
     * @param SumUpHttpClientInterface $client
     * @param $accessToken
     */
    public function __construct(SumUpHttpClientInterface $client, $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Retrieve a profile
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\MerchantAccount
     *
     * @deprecated
     */
    public function get($queryParams = [])
    {
        $path = '/v0.1/me';
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\MerchantAccount::class);
    }

    /**
     * Retrieve DBA
     *
     *
     * @return \SumUp\Types\DoingBusinessAsLegacy
     *
     * @deprecated
     */
    public function getDoingBusinessAs()
    {
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\DoingBusinessAsLegacy::class);
    }

    /**
     * Retrieve a merchant profile
     *
     *
     * @return \SumUp\Types\MerchantProfileLegacy
     *
     * @deprecated
     */
    public function getMerchantProfile()
    {
        $path = '/v0.1/me/merchant-profile';
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\MerchantProfileLegacy::class);
    }

    /**
     * Retrieve a personal profile
     *
     *
     * @return \SumUp\Types\PersonalProfileLegacy
     *
     * @deprecated
     */
    public function getPersonalProfile()
    {
        $path = '/v0.1/me/personal-profile';
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\PersonalProfileLegacy::class);
    }
}
