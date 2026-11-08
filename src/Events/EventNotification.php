<?php

declare(strict_types=1);

namespace SumUp\Events;

use DateTimeImmutable;
use SumUp\Exception\EventObjectException;
use SumUp\Exception\EventPayloadException;
use SumUp\HttpClient\RequestOptions;
use SumUp\ResponseDecoder;
use SumUp\SumUp;

/** A thin event notification bound to the API client that parsed it. */
class EventNotification
{
    /** Use this ID to deduplicate repeated deliveries. */
    public readonly string $id;
    public readonly string $type;
    /** When the event occurred; signature verification uses the delivery timestamp instead. */
    public readonly DateTimeImmutable $createdAt;
    public readonly EventObjectReference $object;

    /**
     * @internal Use the client's parsing methods to create notifications.
     * @param array<string, mixed> $payload
     */
    public function __construct(private SumUp $client, array $payload)
    {
        $this->id = $payload['id'] ?? null;
        $this->type = $payload['type'] ?? null;
        $this->createdAt = new DateTimeImmutable($payload['created_at'] ?? null);
        $this->object = new EventObjectReference(
            $payload['object']['id'] ?? null,
            $payload['object']['type'] ?? null,
            $payload['object']['url'] ?? null
        );
    }

    /** @internal Prefer SumUp::parseEventNotificationWithoutVerification() for trusted stored events. */
    public static function parseWithoutVerification(SumUp $client, string $body): self
    {
        try {
            $payload = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $cause) {
            throw new EventPayloadException('Invalid event JSON or UTF-8.', previous: $cause);
        }
        if (!is_array($payload)) {
            throw new EventPayloadException('Expected an event JSON object.');
        }
        try {
            return EventFactory::create($client, $payload);
        } catch (\Exception | \TypeError $cause) {
            throw new EventPayloadException('Unable to decode event notification.', previous: $cause);
        }
    }

    /**
     * Fetch the resource's current state. Deleted resources may return an API error.
     * Unknown event types return the decoded response for the caller to validate.
     */
    public function fetchObject(?RequestOptions $options = null): mixed
    {
        return $this->fetchResource(null, $options);
    }

    /**
     * @param class-string|null $className
     */
    protected function fetchResource(?string $className, ?RequestOptions $options): mixed
    {
        $url = parse_url($this->object->url);
        if ($url === false || preg_match('/[\x00-\x20\x7f\\\\]/', $this->object->url)) {
            throw new EventObjectException('Invalid event object URL.');
        }
        // Use only the path and query so credentials stay with the configured API client.
        $path = '/' . ltrim($url['path'] ?? '', '/');
        if (isset($url['query'])) {
            $path .= '?' . $url['query'];
        }
        // Keep redirects from sending credentials to another host. Preserve the caller's options.
        $options = $options === null ? new RequestOptions() : clone $options;
        $options->followRedirects = false;
        $response = $this->client->request('GET', $path, [], $options);
        return ResponseDecoder::decodeOrThrow($response, $className, null, 'GET', $path);
    }
}
