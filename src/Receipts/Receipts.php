<?php

declare(strict_types=1);

namespace SumUp\Receipts;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\ResponseDecoder;
use SumUp\SdkInfo;

/**
 * Query parameters for ReceiptsGetParams.
 *
 * @package SumUp\Services
 */
class ReceiptsGetParams
{
    /**
     * Merchant code.
     *
     * @var string
     */
    public string $mid;

    /**
     * The ID of the transaction event (refund).
     *
     * @var int|null
     */
    public ?int $txEventId = null;

}

/**
 * Class Receipts
 *
 * @package SumUp\Services
 */
class Receipts implements SumUpService
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
     * Receipts constructor.
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
     * Retrieve receipt details
     *
     * @param string $id SumUp unique transaction ID or transaction code, e.g. TS7HDYLSKD.
     * @param ReceiptsGetParams|null $queryParams Optional query string parameters
     *
     * @return \SumUp\Types\Receipt
     */
    public function get($id, $queryParams = null)
    {
        $path = sprintf('/v1.1/receipts/%s', rawurlencode((string) $id));
        if ($queryParams !== null) {
            $queryParamsData = [];
            if (isset($queryParams->mid)) {
                $queryParamsData['mid'] = $queryParams->mid;
            }
            if (isset($queryParams->txEventId)) {
                $queryParamsData['tx_event_id'] = $queryParams->txEventId;
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

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Types\Receipt::class);
    }
}
