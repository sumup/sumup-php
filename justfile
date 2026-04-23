set shell := ["bash", "-eu", "-o", "pipefail", "-c"]

# List available recipes. This is the default target.
default: help

# Display all documented targets.
help:
  @just --list

# Backward-compatible alias for installing project dependencies.
vendor: install

# Install all project dependencies.
install:
  composer install

# Update the Composer lockfile.
lock:
  composer update --with-all-dependencies

# Format code using php-cs-fixer.
fmt: install
  vendor/bin/php-cs-fixer fix -v --using-cache=no

# Check code formatting.
fmtcheck: install
  vendor/bin/php-cs-fixer fix -v --using-cache=no --dry-run

# Generate API reference using phpDocumentor.
docs: install
  docker run --rm -v "$PWD:/data" "phpdoc/phpdoc:3"

# Run PHPUnit test suite.
test: install
  composer test

# Run static analysis using PHPStan.
analyse: install
  PHPSTAN_DISABLE_PARALLEL=1 vendor/bin/phpstan analyse --configuration=phpstan.neon --no-progress --memory-limit=1G --debug

# Generate SDK from the local OpenAPI specs.
generate:
  cd codegen && go run ./... generate ../openapi.json ../src
