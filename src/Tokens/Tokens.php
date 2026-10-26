<?php

declare(strict_types=1);

namespace SumUp\Tokens;

namespace SumUp\Services;

use SumUp\HttpClient\HttpClientInterface;
use SumUp\HttpClient\RequestHeaders;
use SumUp\HttpClient\RequestOptions;
use SumUp\RequestEncoder;
use SumUp\ResponseDecoder;

class TokensCreateRequest
{
    /**
     * Actions the token allows for this merchant account.
     *
     * @var string[]
     */
    public array $actions;

    /**
     * Create request DTO.
     *
     * @param string[] $actions
     */
    public function __construct(
        array $actions
    ) {
        \SumUp\Hydrator::hydrate([
            'actions' => $actions,
        ], self::class, $this);
    }

    /**
     * Create request DTO from an associative array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        self::assertRequiredFields($data, [
            'actions' => 'actions',
        ]);

        $request = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        \SumUp\Hydrator::hydrate($data, self::class, $request);

        return $request;
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $requiredFields
     */
    private static function assertRequiredFields(array $data, array $requiredFields): void
    {
        foreach ($requiredFields as $serializedName => $propertyName) {
            if (!array_key_exists($serializedName, $data) && !array_key_exists($propertyName, $data)) {
                throw new \InvalidArgumentException(sprintf('Missing required field "%s".', $serializedName));
            }
        }
    }

}

/**
 * Class Tokens
 *
 * Merchant tokens let your application accept card-present payments with SumUp SDKs that support token-based authentication. Use them when you want users to sign in to your application with your own authentication, then accept payments for a SumUp merchant account.
 *
 * Create tokens on your backend using one of the [supported authentication methods](https://developer.sumup.com/api/authentication). Keep your authentication credentials on your backend. Return only the short-lived merchant token to your application and pass its `access_token` to the SDK.
 *
 * Before returning a token, authenticate the user in your application and check that they can accept payments for the requested merchant account. A merchant token is limited to that account and the requested actions, and does not grant permissions beyond those of the identity that created it.
 *
 * Tokens expire 15 minutes after creation. Use `expires_in` to determine the remaining lifetime and create a new token when needed. This endpoint does not return a refresh token. Treat merchant tokens as secrets: send them over HTTPS and keep them out of URLs, logs, and source code.
 *
 * @package SumUp\Services
 */
class Tokens implements SumUpService
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
     * Tokens constructor.
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
     * Create a merchant token
     *
     * @param string $merchantCode Unique code of the merchant account that will receive the payments.
     * @param TokensCreateRequest|array<string, mixed> $body Required request payload
     * @param RequestOptions|null $requestOptions Optional typed request options
     *
     * @return \SumUp\Types\Token
     * @throws \SumUp\Exception\ApiException
     * @throws \SumUp\Exception\UnexpectedApiException
     * @throws \SumUp\Exception\ConnectionException
     * @throws \SumUp\Exception\SDKException
     */
    public function create(string $merchantCode, TokensCreateRequest|array $body, ?RequestOptions $requestOptions = null): \SumUp\Types\Token
    {
        $path = sprintf('/v0.1/merchants/%s/tokens', rawurlencode((string) $merchantCode));
        $payload = [];
        $requestBody = $body;
        if (is_array($requestBody)) {
            $requestBody = TokensCreateRequest::fromArray($requestBody);
        }
        $payload = RequestEncoder::encode($requestBody);
        $headers = RequestHeaders::build($this->accessToken, $requestOptions);

        $response = $this->client->send('POST', $path, $payload, $headers, $requestOptions);

        return ResponseDecoder::decodeOrThrow($response, \SumUp\Types\Token::class, [
            '400' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '401' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
            '403' => ['type' => 'class', 'class' => \SumUp\Types\Problem::class],
        ], 'POST', $path);
    }
}
