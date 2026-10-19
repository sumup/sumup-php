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
        foreach (['id', 'type', 'created_at'] as $field) {
            if (!isset($payload[$field]) || !is_string($payload[$field]) || $payload[$field] === '') {
                throw new EventPayloadException('Missing or invalid event field: ' . $field . '.');
            }
        }
        $object = $payload['object'] ?? null;
        if (!is_array($object)) {
            throw new EventPayloadException('Expected an event object reference.');
        }
        foreach (['id', 'type', 'url'] as $field) {
            if (!isset($object[$field]) || !is_string($object[$field]) || $object[$field] === '') {
                throw new EventPayloadException('Missing or invalid event object field: ' . $field . '.');
            }
        }
        try {
            $this->createdAt = new DateTimeImmutable($payload['created_at']);
        } catch (\Exception $cause) {
            throw new EventPayloadException('Invalid event creation timestamp.', previous: $cause);
        }
        $this->id = $payload['id'];
        $this->type = $payload['type'];
        $this->object = new EventObjectReference($object['id'], $object['type'], $object['url']);
    }

    /** @internal Prefer SumUp::parseEventNotificationWithoutVerification() for trusted stored events. */
    public static function parseWithoutVerification(SumUp $client, string $body): self
    {
        try {
            $payload = json_decode($body, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $cause) {
            throw new EventPayloadException('Invalid event JSON or UTF-8.', previous: $cause);
        }
        if (!$payload instanceof \stdClass) {
            throw new EventPayloadException('Expected an event JSON object.');
        }
        $data = get_object_vars($payload);
        if (($data['object'] ?? null) instanceof \stdClass) {
            $data['object'] = get_object_vars($data['object']);
        }
        return EventFactory::create($client, $data);
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
        $base = parse_url($this->client->getBaseUri());
        if ($url === false || $base === false
            || !isset($url['scheme'], $url['host'], $base['scheme'], $base['host'])
            || !in_array(strtolower($url['scheme']), ['http', 'https'], true)
            || strtolower($url['scheme']) !== strtolower($base['scheme'])
            || strtolower($url['host']) !== strtolower($base['host'])
            || ($url['port'] ?? (strtolower($url['scheme']) === 'https' ? 443 : 80))
                !== ($base['port'] ?? (strtolower($base['scheme']) === 'https' ? 443 : 80))
            || isset($url['user']) || isset($url['pass']) || isset($url['fragment'])
            || preg_match('/[\x00-\x20\x7f\\\\]/', $this->object->url)
        ) {
            throw new EventObjectException('Event object URL must match the API client origin.');
        }
        $path = $url['path'] ?? '/';
        if (str_starts_with($path, '//')) {
            throw new EventObjectException('Event object path must not start with //.');
        }
        if (isset($url['query'])) {
            $path .= '?' . $url['query'];
        }
        // Keep redirects from bypassing the origin check. Preserve the caller's options.
        $options = $options === null ? new RequestOptions() : clone $options;
        $options->followRedirects = false;
        $response = $this->client->request('GET', $path, [], $options);
        return ResponseDecoder::decodeOrThrow($response, $className, null, 'GET', $path);
    }
}
