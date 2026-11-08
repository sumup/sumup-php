<div align="center">

# SumUp PHP SDK

[![Stars](https://img.shields.io/github/stars/sumup/sumup-php?style=social)](https://github.com/sumup/sumup-php)
[![Latest Stable Version](https://poser.pugx.org/sumup/sumup-php/v/stable.svg)](https://packagist.org/packages/sumup/sumup-php)
[![Total Downloads](https://poser.pugx.org/sumup/sumup-php/downloads.svg)](https://packagist.org/packages/sumup/sumup-php)
[![License](https://img.shields.io/github/license/sumup/sumup-php)](./LICENSE)
[![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-v2.1%20adopted-ff69b4.svg)](https://github.com/sumup/sumup-php/tree/main/CODE_OF_CONDUCT.md)

</div>

## Overview

Use the SumUp PHP SDK to create checkouts, manage card readers, and access the [SumUp API](https://developer.sumup.com/rest-api). Requires PHP 8.2 or later and the cURL extension.

## Installation

Install with [Composer](https://getcomposer.org/):

```bash
composer require sumup/sumup-php
```

## Basic Usage

Set your API key:

```bash
export SUMUP_API_KEY='your-api-key-here'
```

Create a checkout:

```php
require 'vendor/autoload.php';

$sumup = new \SumUp\SumUp();
$checkout = $sumup->checkouts()->create(new \SumUp\Types\CheckoutCreateRequest(
    checkoutReference: 'your-checkout-ref',
    amount: 10.00,
    currency: 'EUR',
    merchantCode: 'YOUR-MERCHANT-CODE',
));

// Pass the checkout ID to your frontend to collect payment.
$checkoutId = $checkout->id;
```

Request methods also accept associative arrays. Use classes from `\SumUp\Types` for autocomplete and type checking, or `TypeName::fromArray($data)` to create a request from an array.

### Providing API Key Programmatically

The SDK reads `SUMUP_API_KEY` automatically. You can also pass an API key when creating the client:

```php
$sumup = new \SumUp\SumUp('your-api-key-here');
```

### Handling errors

Catch `ApiException` for API errors and `SDKException` for connection or configuration errors:

```php
try {
    $checkout = $sumup->checkouts()->get('your-checkout-id');
} catch (\SumUp\Exception\ApiException $error) {
    echo $error->getStatusCode() . ': ' . $error->getMessage();
} catch (\SumUp\Exception\SDKException $error) {
    echo $error->getMessage();
}
```

Use `getProblem()` for error details such as `type` and `detail` when available, or `getResponseBody()` for the full response body. API errors also provide `getResponse()` to access response headers and text.

### TLS Certificates

The SDK includes a CA certificate bundle for HTTPS requests. To use your own certificates, set `ca_bundle_path`:

```php
$sumup = new \SumUp\SumUp([
    'ca_bundle_path' => __DIR__ . '/storage/certs/company-ca.pem',
]);
```

### Custom HTTP Client

To use another HTTP library or add request logging, pass a client that implements `SumUp\HttpClient\HttpClientInterface`:

```php
$sumup = new \SumUp\SumUp([
    'client' => new YourCustomHttpClient(),
]);
```

See [the custom HTTP client example](examples/custom-http-client.php) for a complete implementation.

### Guzzle HTTP Client (Optional)

To use Guzzle, install it and pass a `GuzzleClient` to the SDK:

```bash
composer require guzzlehttp/guzzle
```

```php
$guzzleClient = new \SumUp\HttpClient\GuzzleClient('https://api.sumup.com');
$sumup = new \SumUp\SumUp([
    'api_key' => 'your-api-key-here',
    'client' => $guzzleClient,
]);
```

### Request Options

Set timeouts and retries for individual requests:

```php
$options = new \SumUp\HttpClient\RequestOptions(
    timeout: 30,
    connectTimeout: 10,
    retries: 2,
    retryBackoffMs: 200
);

$checkout = $sumup->checkouts()->get('checkout-id', $options);
```

## Handling Events

Set `SUMUP_EVENT_SECRET` to your event destination's signing secret and register callbacks for the events you need:

```php
use SumUp\Events\EventNotification;
use SumUp\Events\ReaderCreatedEvent;
use SumUp\SumUp;

$sumup = new SumUp();
$events = $sumup->eventsHandler(
    getenv('SUMUP_EVENT_SECRET'),
    function (EventNotification $event): void {
        // Handles events without a registered callback.
        error_log('Unhandled event: ' . $event->type);
    }
)->onReaderCreated(function (ReaderCreatedEvent $event): void {
    $reader = $event->fetchObject();
    error_log('Reader paired: ' . $reader?->id);
});

// In your HTTP route, pass the original body and signature header.
$events->handle(
    file_get_contents('php://input'),
    $_SERVER['HTTP_X_SUMUP_WEBHOOK_SIGNATURE'] ?? ''
);
```

The handler verifies the signature before running callbacks. `fetchObject()` retrieves the resource's current state using your API credentials.

Return a 2xx response after processing succeeds. Return 400 for `EventSignatureException` or `EventPayloadException`, and 500 for `EventCallbackException` so processing can be retried. Deliveries may repeat; use `$event->id` to avoid processing the same event twice.

For queued processing, verify the delivery before storing it. In your worker, use `parseEventNotificationWithoutVerification($body)` and `dispatch($event)` only for previously verified events from trusted storage.

These events are separate from checkout and reader `return_url` callbacks. See [the events example](examples/events.php) for a complete HTTP endpoint and error handling.

## Examples

The repository includes runnable examples:

- `examples/simple.php` - basic SDK initialization and merchant fetch.
  Run with: `php examples/simple.php`
- `examples/checkout.php` - create and process a checkout.
  Run with: `php examples/checkout.php`
- `examples/custom-http-client.php` - wrap/customize HTTP behavior.
  Run with: `php examples/custom-http-client.php`
- `examples/guzzle-http-client.php` - use the built-in Guzzle client.
  Run with: `php examples/guzzle-http-client.php`
- `examples/events.php` - receive and verify signed events.
  Run with: `SUMUP_EVENT_SECRET='your-signing-secret' php -S localhost:8080 examples/events.php`

For checkout-related examples, set:

```bash
export SUMUP_API_KEY='your-api-key-here'
export SUMUP_MERCHANT_CODE='your-merchant-code'
```

## API Reference

See the [SumUp API reference](https://developer.sumup.com/rest-api) for available endpoints, request parameters, and response details.

## License

Licensed under [Apache 2.0](LICENSE).

## Contact Us

For bugs and feature requests, [open an issue](https://github.com/sumup/sumup-php/issues/new). For integration help, contact [integration@sumup.com](mailto:integration@sumup.com).
