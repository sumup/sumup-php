# Response for the SumUp Ecommerce SDK for PHP

## \SumUp\HttpClients\Response

The `\SumUp\HttpClients\Response` object represents a raw HTTP response.

> Most generated services now decode success responses and return typed SDK models directly. The `Response` object remains available for lower-level helpers (such as the `Authorization` service) and when working with custom HTTP clients.

## Instance Methods

### getHttpResponseCode()

```php
public function getHttpResponseCode(): int
```

Returns the HTTP response code.

### getBody()

```php
public function getBody(): mixed
```

Returns different object according to the service's response.
