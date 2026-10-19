<?php

declare(strict_types=1);

namespace SumUp\Events;

use SumUp\Exception\EventCallbackException;
use SumUp\Exception\EventSignatureException;
use SumUp\SumUp;

/** Verifies and dispatches deliveries. Complete processing before acknowledging the request. */
abstract class EventsHandlerBase
{
    /** @var \Closure(EventNotification): void */
    private \Closure $fallback;
    /** @var array<string, callable(EventNotification): void> */
    private array $callbacks = [];

    /** @param callable(EventNotification): void $fallback Unknown and unregistered event types. */
    public function __construct(
        private SumUp $client,
        #[\SensitiveParameter] private string $secret,
        callable $fallback
    ) {
        if ($secret === '') {
            throw new EventSignatureException('Event signing secret is required.');
        }
        $this->fallback = \Closure::fromCallable($fallback);
    }

    /** Verify and parse without invoking callbacks. */
    public function parse(string $body, string $signature): EventNotification
    {
        return $this->client->parseEventNotification($body, $signature, $this->secret);
    }

    /**
     * Pass the unchanged body and complete X-SumUp-Webhook-Signature header value.
     * Callbacks only run after verification. Processing failures preserve their cause.
     * Make side effects idempotent using the event ID; deliveries may repeat.
     *
     * @throws EventCallbackException
     */
    public function handle(string $body, string $signature): void
    {
        $event = $this->parse($body, $signature);
        $callback = $this->callbacks[$event->type] ?? $this->fallback;
        try {
            $callback($event);
        } catch (\Throwable $cause) {
            throw new EventCallbackException('Event callback failed.', previous: $cause);
        }
    }

    /** @param callable(EventNotification): void $callback */
    protected function register(string $type, callable $callback): void
    {
        $this->callbacks[$type] = $callback;
    }
}
