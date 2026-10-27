<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Events\CheckoutPaidEvent;
use SumUp\Events\EventNotification;
use SumUp\Events\EventSignature;
use SumUp\Events\MemberUpdatedEvent;
use SumUp\Events\ReaderCreatedEvent;
use SumUp\Events\RoleDeletedEvent;
use SumUp\Events\UnknownEvent;
use SumUp\Exception\EventCallbackException;
use SumUp\Exception\EventObjectException;
use SumUp\Exception\EventPayloadException;
use SumUp\Exception\EventSignatureException;
use SumUp\Exception\EventSignatureExpiredException;
use SumUp\Exception\UnexpectedApiException;
use SumUp\HttpClient\RequestOptions;
use SumUp\HttpClient\Response;
use SumUp\SumUp;
use SumUp\Tests\Doubles\FakeHttpClient;
use SumUp\Types\Checkout;
use SumUp\Types\Member;
use SumUp\Types\Reader;
use SumUp\Types\Role;

class EventsTest extends TestCase
{
    private const SECRET = 'event_secret_test';
    private const URL = 'https://api.sumup.test/v0.1/readers/rdr_123';

    private function client(?FakeHttpClient $http = null): SumUp
    {
        return new SumUp([
            'api_key' => 'api-key',
            'base_uri' => 'https://api.sumup.test',
            'client' => $http ?? new FakeHttpClient(new Response(200, ['id' => 'rdr_123'])),
        ]);
    }

    private function body(string $type = 'readers.created', string $url = self::URL): string
    {
        return json_encode([
            'id' => 'evt_123',
            'type' => $type,
            'created_at' => '2026-04-11T10:00:00Z',
            'object' => ['id' => 'rdr_123', 'type' => 'reader', 'url' => $url],
        ], JSON_THROW_ON_ERROR);
    }

    private function signature(string $body, ?string $timestamp = null, string $secret = self::SECRET): string
    {
        $timestamp = $timestamp ?? (string) time();
        return 't=' . $timestamp . ',v1=' . hash_hmac('sha256', 'v1:' . $timestamp . ':' . $body, $secret);
    }

    public static function eventTypes(): array
    {
        return [
            ['readers.created', ReaderCreatedEvent::class, Reader::class],
            ['checkouts.paid', CheckoutPaidEvent::class, Checkout::class],
            ['members.updated', MemberUpdatedEvent::class, Member::class],
            ['roles.deleted', RoleDeletedEvent::class, Role::class],
        ];
    }

    /** @dataProvider eventTypes */
    public function testParsesTypedNotificationsAndFetchesResources(string $type, string $eventClass, string $resourceClass): void
    {
        $http = new FakeHttpClient(new Response(200, ['id' => 'resource_123']));
        $client = $this->client($http);
        $body = $this->body($type);
        $event = $client->parseEventNotification($body, $this->signature($body), self::SECRET);

        $this->assertInstanceOf($eventClass, $event);
        $this->assertSame('evt_123', $event->id);
        $this->assertSame('2026-04-11T10:00:00+00:00', $event->createdAt->format(DATE_ATOM));
        $this->assertSame(self::URL, $event->object->url);
        $this->assertSame([], $http->getRequests());
        $this->assertInstanceOf($resourceClass, $event->fetchObject());
        $this->assertSame('Bearer api-key', $http->getRequests()[0]['headers']['Authorization']);
    }

    public function testDispatchesTypedCallbacksAndFallbacks(): void
    {
        $seen = [];
        $handler = $this->client()->eventsHandler(self::SECRET, function (EventNotification $event) use (&$seen): void {
            $seen[] = $event;
        })->onReaderCreated(function (ReaderCreatedEvent $event) use (&$seen): void {
            $seen[] = $event;
        });

        foreach (['readers.created', 'roles.deleted', 'future.created'] as $type) {
            $body = $this->body($type);
            $handler->handle($body, $this->signature($body));
        }
        $this->assertCount(3, $seen);
        $this->assertInstanceOf(ReaderCreatedEvent::class, $seen[0]);
        $this->assertInstanceOf(RoleDeletedEvent::class, $seen[1]);
        $this->assertInstanceOf(UnknownEvent::class, $seen[2]);
        $this->assertSame(['id' => 'rdr_123'], $seen[2]->fetchObject());
    }

    public function testHandlerParseDoesNotRunCallbacksAndRegistrationReplacesPrevious(): void
    {
        $handler = $this->client()->eventsHandler(self::SECRET, function (): void {
            $this->fail('Fallback should not run.');
        })->onReaderCreated(function (): void {
            $this->fail('Replaced callback should not run.');
        });
        $seen = [];
        $this->assertSame($handler, $handler->onReaderCreated(function (ReaderCreatedEvent $event) use (&$seen): void {
            $seen[] = $event;
        }));
        $body = $this->body();
        $this->assertInstanceOf(ReaderCreatedEvent::class, $handler->parse($body, $this->signature($body)));
        $this->assertSame([], $seen);
        $handler->handle($body, $this->signature($body));
        $this->assertCount(1, $seen);
    }

    public function testPreservesCallbackFailureForRetryHandling(): void
    {
        $cause = new \RuntimeException('Processing failed.');
        $handler = $this->client()->eventsHandler(self::SECRET, static function () use ($cause): void {
            throw $cause;
        });
        $body = $this->body();
        try {
            $handler->handle($body, $this->signature($body));
            $this->fail('Expected a callback exception.');
        } catch (EventCallbackException $exception) {
            $this->assertSame($cause, $exception->getPrevious());
        }
    }

    public function testVerifiesExactRawBytesAndTimestampSpelling(): void
    {
        $body = "{\n  \"message\": \"café\"\n}";
        $signature = $this->signature($body, '0' . time());
        EventSignature::verify(self::SECRET, $body, $signature);
        $this->expectException(EventSignatureException::class);
        EventSignature::verify(self::SECRET, $body . "\n", $signature);
    }

    public function testMatchesIndependentSignatureVector(): void
    {
        // Computed with OpenSSL HMAC-SHA256 over v1:1234567890:{"id":"evt_123"}.
        // Reaching the expiry check proves that the signature itself matched.
        $this->expectException(EventSignatureExpiredException::class);
        EventSignature::verify(
            self::SECRET,
            '{"id":"evt_123"}',
            't=1234567890,v1=94a0f7740d808830926eb68b0b2710d8fe7acf8e51475616417a05e55bb2ba1f'
        );
    }

    public static function invalidSignatures(): array
    {
        return [
            [''], ['t=123'], ['v1=' . str_repeat('a', 64)],
            ['t=1.5,v1=' . str_repeat('a', 64)],
            ['t=-1,v1=' . str_repeat('a', 64)],
            ['t=9999999999999999999999,v1=' . str_repeat('a', 64)],
            ['t=123,v1=xyz'], ['t=123,v1=' . str_repeat('a', 64) . ',extra=1'],
        ];
    }

    /** @dataProvider invalidSignatures */
    public function testRejectsMalformedSignatureHeaders(string $signature): void
    {
        $this->expectException(EventSignatureException::class);
        EventSignature::verify(self::SECRET, $this->body(), $signature);
    }

    public function testRejectsWrongSecretBeforeInvokingCallbacks(): void
    {
        $handler = $this->client()->eventsHandler(self::SECRET, function (): void {
            $this->fail('Callback must not run before verification.');
        });
        $body = $this->body();
        $this->expectException(EventSignatureException::class);
        $handler->handle($body, $this->signature($body, secret: 'wrong-secret'));
    }

    public function testRequiresSigningSecret(): void
    {
        $this->expectException(EventSignatureException::class);
        $this->client()->eventsHandler('', static function (): void {
        });
    }

    public static function expiredTimestamps(): array
    {
        return [[-600], [600]];
    }

    /** @dataProvider expiredTimestamps */
    public function testRejectsOldAndFutureDeliveries(int $offset): void
    {
        $body = $this->body();
        $this->expectException(EventSignatureExpiredException::class);
        EventSignature::verify(self::SECRET, $body, $this->signature($body, (string) (time() + $offset)));
    }

    public static function invalidPayloads(): array
    {
        return [['{'], ['[]'], ['null'], ['42'], ['{}'], ["{\"id\":\"\xff\"}"]];
    }

    /** @dataProvider invalidPayloads */
    public function testRejectsInvalidPayloadsWithoutCallingCallbacks(string $body): void
    {
        $handler = $this->client()->eventsHandler(self::SECRET, function (): void {
            $this->fail('Callback must not run for invalid JSON.');
        });
        $this->expectException(EventPayloadException::class);
        $handler->handle($body, $this->signature($body));
    }

    public function testParsesTrustedStoredEventAndRetainsRequestConfiguration(): void
    {
        $http = new FakeHttpClient(new Response(200, ['id' => 'rdr_123']));
        $client = $this->client($http);
        $event = $client->parseEventNotificationWithoutVerification($this->body(url: self::URL . '?expand=device'));
        $client->setDefaultAccessToken('updated-key');
        $options = new RequestOptions(timeout: 15, retries: 2, headers: ['X-Integrator' => 'test'], followRedirects: true);
        $event->fetchObject($options);
        $request = $http->getRequests()[0];
        $this->assertSame('GET', $request['method']);
        $this->assertSame('/v0.1/readers/rdr_123?expand=device', $request['url']);
        $this->assertSame('Bearer updated-key', $request['headers']['Authorization']);
        $this->assertSame('test', $request['headers']['X-Integrator']);
        $this->assertSame(15, $request['options']->timeout);
        $this->assertSame(2, $request['options']->retries);
        $this->assertFalse($request['options']->followRedirects);
        $this->assertTrue($options->followRedirects);
    }

    public static function unsafeUrls(): array
    {
        return [
            ['https://attacker.test/resource'], ['http://api.sumup.test/resource'],
            ['https://api.sumup.test:444/resource'], ['/resource'],
            ['https://api.sumup.test//attacker.test/resource'],
            ['https://user:password@api.sumup.test/resource'],
            ['https://api.sumup.test/resource#fragment'],
            ['https://api.sumup.test/\\attacker.test/resource'],
            ["https://api.sumup.test/resource\n"],
        ];
    }

    /** @dataProvider unsafeUrls */
    public function testRejectsUnsafeObjectUrlsWithoutSendingCredentials(string $url): void
    {
        $http = new FakeHttpClient(new Response(200, []), true);
        $event = $this->client($http)->parseEventNotificationWithoutVerification($this->body(url: $url));
        $this->expectException(EventObjectException::class);
        $event->fetchObject();
    }

    public function testAcceptsEquivalentOriginsAndDefaultPorts(): void
    {
        $event = $this->client()->parseEventNotificationWithoutVerification(
            $this->body(url: 'https://API.SUMUP.TEST:443/v0.1/readers/rdr_123')
        );
        $this->assertInstanceOf(Reader::class, $event->fetchObject());
    }

    public function testPropagatesApiErrorsForDeletedResources(): void
    {
        $http = new FakeHttpClient(new Response(404, ['message' => 'Deleted']));
        $event = $this->client($http)->parseEventNotificationWithoutVerification($this->body('readers.deleted'));
        $this->expectException(UnexpectedApiException::class);
        $event->fetchObject();
    }
}
