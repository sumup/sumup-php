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
    protected HttpClientInterface $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var string
     */
    protected string $accessToken;

    /**
     * Merchant constructor.
     *
     * @param HttpClientInterface $client
     * @param string $accessToken
     */
    public function __construct(HttpClientInterface $client, string $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Retrieve a profile
     *
     * @param MerchantGetParams|null $queryParams Optional query string parameters
     * @param array<string, mixed>|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\MerchantAccount
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function get(?MerchantGetParams $queryParams = null, ?array $requestOptions = null): \SumUp\Types\MerchantAccount
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

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\MerchantAccount::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * Retrieve DBA
     *
     * @param array<string, mixed>|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\DoingBusinessAsLegacy
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function getDoingBusinessAs(?array $requestOptions = null): \SumUp\Types\DoingBusinessAsLegacy
    {
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\DoingBusinessAsLegacy::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * Retrieve a merchant profile
     *
     * @param array<string, mixed>|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\MerchantProfileLegacy
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function getMerchantProfile(?array $requestOptions = null): \SumUp\Types\MerchantProfileLegacy
    {
        $path = '/v0.1/me/merchant-profile';
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\MerchantProfileLegacy::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\ErrorForbidden::class],
        ], 'GET', $path);
    }

    /**
     * Retrieve a personal profile
     *
     * @param array<string, mixed>|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return \SumUp\Types\PersonalProfileLegacy
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     *
     * @deprecated
     */
    public function getPersonalProfile(?array $requestOptions = null): \SumUp\Types\PersonalProfileLegacy
    {
        $path = '/v0.1/me/personal-profile';
        $payload = [];
        $headers = ['Content-Type' => 'application/json', 'User-Agent' => SdkInfo::getUserAgent()];
        $headers = array_merge($headers, SdkInfo::getRuntimeHeaders());
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        $response = $this->client->send('GET', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\PersonalProfileLegacy::class, [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }
}
