# Make this makefile self-documented with target `help`
.PHONY: help
.DEFAULT_GOAL := help
help: ## Show help
	@grep -Eh '^[0-9a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: vendor
vendor: install ## Backward-compatible alias for install

.PHONY: install
install: composer.json composer.lock ## Install all project dependencies
	composer install

.PHONY: lock
lock: ## Update the lockfile
	composer update --with-all-dependencies

.PHONY: fmt
fmt: install ## Format code using php-cs-fixer
	vendor/bin/php-cs-fixer fix -v --using-cache=no

.PHONY: fmtcheck
fmtcheck: install ## Check code formatting
	vendor/bin/php-cs-fixer fix -v --using-cache=no --dry-run

.PHONY: docs
docs: install ## Generate API reference using phpDocumentor
	docker run --rm -v "$(CURDIR):/data" "phpdoc/phpdoc:3"

.PHONY: test
test: install ## Run PHPUnit test suite
	composer test

.PHONY: analyse
analyse: install ## Run static analysis (PHPStan)
	PHPSTAN_DISABLE_PARALLEL=1 composer analyse

.PHONY: generate
generate: ## Generate SDK from the local OpenAPI specs
	cd codegen && go run ./... generate ../openapi.json ../src
