<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

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
     * @var SumUpHttpClientInterface
     */
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * Payouts constructor.
     *
     * @param SumUpHttpClientInterface $client
     * @param AccessToken $accessToken
     */
    public function __construct(SumUpHttpClientInterface $client, AccessToken $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * List payouts
     *
     * @param string $merchantCode
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Payouts\FinancialPayouts
     */
    public function list($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v1.0/merchants/%s/payouts', rawurlencode((string) $merchantCode));
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Payouts\FinancialPayouts::class],
        ]);
    }

    /**
     * List payouts
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\Payouts\FinancialPayouts
     *
     * @deprecated
     */
    public function listDeprecated($queryParams = [])
    {
        $path = '/v0.1/me/financials/payouts';
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'class', 'class' => \SumUp\Payouts\FinancialPayouts::class],
        ]);
    }
}
