<?php

declare(strict_types=1);

namespace SumUp\Types;

/**
 * A short-lived credential for the requested merchant account and actions. Pass access_token to a SumUp SDK that supports merchant tokens.
 */
class Token
{
    /**
     * Secret token to pass to the SDK. Treat this value as an opaque string; do not parse it or depend on its format.
     *
     * @var string
     */
    public string $accessToken;

    /**
     * Authentication scheme used by the token. Always Bearer.
     *
     * @var TokenTokenType
     */
    public TokenTokenType $tokenType;

    /**
     * Remaining lifetime of the token in seconds when the response is created. Tokens expire 15 minutes after creation. Request a new token when needed.
     *
     * @var int
     */
    public int $expiresIn;

}
