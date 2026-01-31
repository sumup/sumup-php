<div align="center">

# SumUp PHP SDK

[![Stars](https://img.shields.io/github/stars/sumup/sumup-php?style=social)](https://github.com/sumup/sumup-go/)
[![Latest Stable Version](https://poser.pugx.org/sumup/sumup-php/v/stable.svg)](https://packagist.org/packages/sumup/sumup-php)
[![Total Downloads](https://poser.pugx.org/sumup/sumup-php/downloads.svg)](https://packagist.org/packages/sumup/sumup-php)
[![License](https://img.shields.io/github/license/sumup/sumup-go)](./LICENSE)
[![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-v2.1%20adopted-ff69b4.svg)](https://github.com/sumup/sumup-go/tree/main/CODE_OF_CONDUCT.md)

</div>

## Overview

This repository contains the open source PHP SDK that allows you to integrate quickly with the SumUp's [API](https://developer.sumup.com/rest-api) endpoints.

## Installation

The SumUp PHP SDK can be installed with [Composer](https://getcomposer.org/). Run the following command:

```bash
composer require sumup/sumup-php
```

## Basic Usage

Before using the SDK, set the `SUMUP_API_KEY` environment variable with your API key. The SDK will automatically use this key for authentication.

```bash
export SUMUP_API_KEY='your-api-key-here'
```

Then create checkouts and use other API endpoints:

```php
try {
    // SDK automatically uses SUMUP_API_KEY environment variable
    $sumup = new \SumUp\SumUp();
    
    $checkout = $sumup->checkouts->create([
        'amount' => 10.00,
        'currency' => 'EUR',
        'checkout_reference' => 'your-checkout-ref',
        'merchant_code' => 'YOUR-MERCHANT-CODE',
    ]);
    
    $checkoutId = $checkout->id;
    // Pass the $checkoutId to the front-end to be processed
} catch (\SumUp\Exception\AuthenticationException $e) {
    echo 'Authentication error: ' . $e->getMessage();
} catch (\SumUp\Exception\ValidationException $e) {
    echo 'Validation error: ' . $e->getMessage();
} catch (\SumUp\Exception\SDKException $e) {
    echo 'SumUp SDK error (status ' . $e->getStatusCode() . '): ' . $e->getMessage();
    // Inspect the parsed response body for additional details.
    var_dump($e->getResponseBody());
}
```

Unexpected responses are wrapped in `SDKException`, which now exposes the HTTP status code (`getStatusCode()`) and the decoded payload (`getResponseBody()`), making it easier to inspect raw error payloads that don't match the SDK's validation/authentication error formats.

### Providing API Key Programmatically

If you prefer to provide the API key directly in your code instead of using the environment variable:

```php
$sumup = new \SumUp\SumUp('your-api-key-here');
```

### TLS Certificates

The SDK ships with the latest Mozilla CA bundle to prevent `SSL certificate problem: unable to get local issuer certificate` errors on Windows and other environments that do not expose a system-wide trust store. You can override the bundled file by passing the `ca_bundle_path` configuration key:

```php
$sumup = new \SumUp\SumUp([
    'ca_bundle_path' => __DIR__ . '/storage/certs/company-ca.pem',
]);
```

If not provided, the bundled `resources/ca-bundle.crt` file is used automatically by the cURL HTTP client.

### Custom HTTP Client

The SDK allows you to use a custom HTTP client for making requests. By default, the SDK uses cURL, but you can provide your own implementation:

```php
// Create your custom HTTP client that implements HttpClientInterface
$customClient = new YourCustomHttpClient();

// Pass it to the SDK (uses SUMUP_API_KEY environment variable)
$sumup = new \SumUp\SumUp([
    'client' => $customClient,
]);

// Or provide API key explicitly
$sumup = new \SumUp\SumUp([
    'api_key' => 'your-api-key-here',
    'client' => $customClient,
]);
```

This is useful for adding logging, retry logic, or using a different HTTP library. See `examples/custom-http-client.php` for a complete example. If you prefer Guzzle, check `examples/guzzle-http-client.php` (requires `guzzlehttp/guzzle`).

### Guzzle HTTP Client (Optional)

If you want to use Guzzle, the SDK ships with a built-in client that does not add a hard dependency. Install Guzzle and pass the client into the SDK:

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

## API Reference

For a full list of available services and methods, explore the `src/Services/` directory or check the inline documentation in the code.

## License

For information about the license see the [license](https://github.com/sumup/sumup-php/blob/master/LICENSE.md) file.

## Contact Us

If you have found a bug or you lack some functionality please [open an issue](https://github.com/sumup/sumup-php/issues/new). If you have other issues when integrating with SumUp's API you can send an email to [integration@sumup.com](mailto:integration@sumup.com).
