<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;
use SumUp\Utils\ResponseDecoder;

/**
 * Class Members
 *
 * @package SumUp\Services
 */
class Members implements SumUpService
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
     * Members constructor.
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
     * Create a member
     *
     * @param string $merchantCode Merchant code.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Members\Member
     */
    public function create($merchantCode, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/members', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('POST', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '201' => ['type' => 'class', 'class' => \SumUp\Members\Member::class],
        ]);
    }

    /**
     * Delete a member
     *
     * @param string $merchantCode Merchant code.
     * @param string $memberId The ID of the member to retrieve.
     *
     * @return null
     */
    public function delete($merchantCode, $memberId)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('DELETE', $path, $payload, $headers);

        return ResponseDecoder::decode($response, [
            '200' => ['type' => 'void'],
        ]);
    }

    /**
     * Retrieve a member
     *
     * @param string $merchantCode Merchant code.
     * @param string $memberId The ID of the member to retrieve.
     *
     * @return \SumUp\Members\Member
     */
    public function get($merchantCode, $memberId)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('GET', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Members\Member::class);
    }

    /**
     * List members
     *
     * @param string $merchantCode Merchant code.
     * @param array $queryParams Optional query string parameters
     *
     * @return array
     */
    public function list($merchantCode, $queryParams = [])
    {
        $path = sprintf('/v0.1/merchants/%s/members', rawurlencode((string) $merchantCode));
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
            '200' => ['type' => 'object'],
        ]);
    }

    /**
     * Update a member
     *
     * @param string $merchantCode Merchant code.
     * @param string $memberId The ID of the member to retrieve.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\Members\Member
     */
    public function update($merchantCode, $memberId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/members/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $memberId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        $response = $this->client->send('PUT', $path, $payload, $headers);

        return ResponseDecoder::decode($response, \SumUp\Members\Member::class);
    }
}
