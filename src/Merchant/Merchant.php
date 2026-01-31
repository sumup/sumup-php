<?php

declare(strict_types=1);

namespace SumUp\Merchant;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

/**
 * Query parameters for MerchantGetParams.
 *
 * @package SumUp\Services
 */
class MerchantGetParams
{
    /**
     * A list of additional information you want to receive for the user. By default only personal and merchant profile information will be returned.
     *
     * @var string[]|null
     */
    public ?array $includeList = null;

}

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
     * @var HttpClientInterface
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
     * @param HttpClientInterface $client
     * @param $accessToken
     */
    public function __construct(HttpClientInterface $client, $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Retrieve a profile
     *
     * @param MerchantGetParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\MerchantAccount
     *
     * @deprecated
     */
    public function get($queryParams = null, $requestOptions = null)
    {
        $path = '/v0.1/me';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->includeList)) {
                $queryParamsData['include[]'] = $queryParams->includeList;
            }
            if (!empty($queryParamsData)) {
                $queryString = http_build_query($queryParamsData);
                if (!empty($queryString)) {
                    $path .= '?' . $queryString;
                }
            }
        }
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\MerchantAccount::class);
    }

    /**
     * Retrieve DBA
     *
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\DoingBusinessAsLegacy
     *
     * @deprecated
     */
    public function getDoingBusinessAs($requestOptions = null)
    {
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\DoingBusinessAsLegacy::class);
    }

    /**
     * Retrieve a merchant profile
     *
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\MerchantProfileLegacy
     *
     * @deprecated
     */
    public function getMerchantProfile($requestOptions = null)
    {
        $path = '/v0.1/me/merchant-profile';
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\MerchantProfileLegacy::class);
    }

    /**
     * Retrieve a personal profile
     *
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\PersonalProfileLegacy
     *
     * @deprecated
     */
    public function getPersonalProfile($requestOptions = null)
    {
        $path = '/v0.1/me/personal-profile';
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decode($response, \SumUp\Types\PersonalProfileLegacy::class);
    }
}
