<?php

/**
 * Set SUMUP_API_KEY and SUMUP_EVENT_SECRET, then run:
 * php -S localhost:8080 examples/events.php
 * Expose the endpoint over HTTPS when configuring an event destination.
 */

require __DIR__ . '/../vendor/autoload.php';

use SumUp\Events\EventNotification;
use SumUp\Events\ReaderCreatedEvent;
use SumUp\Exception\EventCallbackException;
use SumUp\Exception\EventPayloadException;
use SumUp\Exception\EventSignatureException;
use SumUp\SumUp;

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit;
}

$secret = getenv('SUMUP_EVENT_SECRET');
if ($secret === false || $secret === '') {
    error_log('Set SUMUP_EVENT_SECRET to the endpoint signing secret.');
    http_response_code(500);
    exit;
}

// Also configure an appropriate body limit in your web server or hosting platform.
$maxBodyBytes = 1024 * 1024;
$body = file_get_contents('php://input', false, null, 0, $maxBodyBytes + 1);
if ($body === false) {
    http_response_code(400);
    exit;
}
if (strlen($body) > $maxBodyBytes) {
    http_response_code(413);
    exit;
}

$sumup = new SumUp();
$events = $sumup->eventsHandler($secret, static function (EventNotification $event): void {
    error_log('Received ' . $event->type . ' (' . $event->id . ')');
})->onReaderCreated(static function (ReaderCreatedEvent $event): void {
    // Fetches the latest resource using SUMUP_API_KEY, not the event signing secret.
    $reader = $event->fetchObject();
    error_log('Reader paired: ' . $reader?->id);
    // Make any side effects idempotent using $event->id; deliveries may repeat.
});

try {
    $events->handle($body, $_SERVER['HTTP_X_SUMUP_WEBHOOK_SIGNATURE'] ?? '');
    http_response_code(204);
} catch (EventSignatureException | EventPayloadException $exception) {
    http_response_code(400);
} catch (EventCallbackException $exception) {
    // Record failures in your application monitoring; avoid logging secrets or payloads.
    error_log('Event processing failed.');
    http_response_code(500);
}
