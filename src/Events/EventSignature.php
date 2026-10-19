<?php

declare(strict_types=1);

namespace SumUp\Events;

use SumUp\Exception\EventSignatureException;
use SumUp\Exception\EventSignatureExpiredException;

/** Verifies signed event deliveries before parsing or storing them. */
final class EventSignature
{
    public const HEADER = 'X-SumUp-Webhook-Signature';

    /**
     * Verify the unchanged request body using the endpoint signing secret, not an API key.
     * The complete header must contain a signing timestamp within five minutes of this server.
     * Successful verification does not validate the JSON payload.
     *
     * @throws EventSignatureException
     */
    public static function verify(#[\SensitiveParameter] string $secret, string $body, string $signature): void
    {
        if ($secret === '') {
            throw new EventSignatureException('Event signing secret is required.');
        }
        if (!preg_match('/\At=([0-9]+),v1=([0-9a-fA-F]{64})\z/', trim($signature), $matches)) {
            throw new EventSignatureException('Invalid event signature header.');
        }

        $timestamp = filter_var(ltrim($matches[1], '0') ?: '0', FILTER_VALIDATE_INT);
        if ($timestamp === false) {
            throw new EventSignatureException('Invalid signing timestamp.');
        }
        $expected = hash_hmac('sha256', 'v1:' . $matches[1] . ':' . $body, $secret);
        if (!hash_equals($expected, strtolower($matches[2]))) {
            throw new EventSignatureException('Invalid event signature.');
        }
        if (abs(time() - $timestamp) > 300) {
            throw new EventSignatureExpiredException('Event timestamp outside the five-minute window.');
        }
    }
}
