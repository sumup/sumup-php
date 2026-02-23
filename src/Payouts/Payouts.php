<?php

declare(strict_types=1);

namespace SumUp\Payouts;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

/**
 * Query parameters for PayoutsListParams.
 *
 * @package SumUp\Services
 */
class PayoutsListParams
{
    /**
     * Start date (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string
     */
    public string $startDate;

    /**
     * End date (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string
     */
    public string $endDate;

    /**
     *
     * @var string|null
     */
    public ?string $format = null;

    /**
     *
     * @var int|null
     */
    public ?int $limit = null;

    /**
     *
     * @var string|null
     */
    public ?string $order = null;

}

/**
 * Query parameters for PayoutsListDeprecatedParams.
 *
 * @package SumUp\Services
 */
class PayoutsListDeprecatedParams
{
    /**
     * Start date (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string
     */
    public string $startDate;

    /**
     * End date (in [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) format).
     *
     * @var string
     */
    public string $endDate;

    /**
     *
     * @var string|null
     */
    public ?string $format = null;

    /**
     *
     * @var int|null
     */
    public ?int $limit = null;

    /**
     *
     * @var string|null
     */
    public ?string $order = null;

}

/**
 * Class Payouts
 *
 * @package SumUp\Services
 */
class Payouts implements SumUpService
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
     * Payouts constructor.
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
     * List payouts
     *
     * @param string $merchantCode
     * @param PayoutsListParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return array[]
     */
    public function list(string $merchantCode, ?PayoutsListParams $queryParams = null, ?array $requestOptions = null): array
    {
        $path = sprintf('/v1.0/merchants/%s/payouts', rawurlencode((string) $merchantCode));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->startDate)) {
                $queryParamsData['start_date'] = $queryParams->startDate;
            }
            if (isset($queryParams->endDate)) {
                $queryParamsData['end_date'] = $queryParams->endDate;
            }
            if (isset($queryParams->format)) {
                $queryParamsData['format'] = $queryParams->format;
            }
            if (isset($queryParams->limit)) {
                $queryParamsData['limit'] = $queryParams->limit;
            }
            if (isset($queryParams->order)) {
                $queryParamsData['order'] = $queryParams->order;
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

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'object']],
        ], [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }

    /**
     * List payouts
     *
     * @param PayoutsListDeprecatedParams|null $queryParams Optional query string parameters
     * @param array|null $requestOptions Optional request options (timeout, connect_timeout, retries, retry_backoff_ms)
     *
     * @return array[]
     *
     * @deprecated
     */
    public function listDeprecated(?PayoutsListDeprecatedParams $queryParams = null, ?array $requestOptions = null): array
    {
        $path = '/v0.1/me/financials/payouts';
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->startDate)) {
                $queryParamsData['start_date'] = $queryParams->startDate;
            }
            if (isset($queryParams->endDate)) {
                $queryParamsData['end_date'] = $queryParams->endDate;
            }
            if (isset($queryParams->format)) {
                $queryParamsData['format'] = $queryParams->format;
            }
            if (isset($queryParams->limit)) {
                $queryParamsData['limit'] = $queryParams->limit;
            }
            if (isset($queryParams->order)) {
                $queryParamsData['order'] = $queryParams->order;
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

        return ResponseDecoder::decodeOrThrow($response, [
            '200' => ['type' => 'array', 'items' => ['type' => 'object']],
        ], [
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Error::class],
        ], 'GET', $path);
    }
}
