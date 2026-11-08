<div align="center">

# sumup-php codegen

A tiny OpenAPI specs to SDK generator for [sumup-php](https://github.com/sumup/sumup-php) SDK.

</div>

## Quickstart

Generate the SDK using the JSON spec:

```sh
go run . generate ../openapi.json ./build
```

> Note: The PHP SDK now ships only with `openapi.json`; the YAML version is no longer maintained.

## PHP Code Samples

The `samples` command generates a deterministic, versioned JSON catalog from the same OpenAPI model used to generate the SDK. Each entry contains a complete PHP program that calls the generated service method. Named OpenAPI request examples produce separate entries.

Generate the catalog from the repository root with:

```sh
just generate-codesamples
```

The recipe writes `code-samples.json` in the repository root by default. Pass another path as its argument to write it elsewhere. The generated file is ignored in this repository, and the codegen tests lint every program with PHP. Published releases regenerate the catalog from the release tag and open or update a pull request in `sumup/sumup-developer`.

## Features

### Enum Support

The codegen automatically generates PHP 8.1+ backed enums for properties with enum constraints in the OpenAPI specification. Enums are consolidated within their respective tag files alongside model classes.

For example, given an OpenAPI schema property:

```yaml
status:
  type: string
  enum:
    - PENDING
    - FAILED
    - PAID
```

The generator creates:
1. A PHP enum (e.g., `CheckoutStatus` in `Checkouts.php`):
```php
enum CheckoutStatus: string
{
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case PAID = 'PAID';
}
```

2. Model properties with enum types:
```php
public ?CheckoutStatus $status = null;
```

#### File Organization

All enums for a tag are generated at the top of the tag's PHP file, followed by the model classes. This keeps related enums and models together while minimizing the number of files.

**Example structure of `Checkouts.php`:**
```php
<?php
namespace SumUp\Checkouts;

enum CheckoutStatus: string { /* ... */ }
enum CardType: string { /* ... */ }
// ... other enums ...

class Checkout { /* ... */ }
class CheckoutRequest { /* ... */ }
// ... other classes ...
```

#### Autoloading

Composer's `classmap` covers `src/`, including generated files with multiple classes and enums. The generator also writes `src/ServiceAccessors.php`, which provides the API group methods used by `SumUp`. Adding an API group to the specification therefore adds its client accessor and autoloading without a manual registration step.
