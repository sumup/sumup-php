# Make this makefile self-documented with target `help`
.PHONY: help
.DEFAULT_GOAL := help
help: ## Show help
	@grep -Eh '^[0-9a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: vendor
vendor: composer.json ## Install dependencies
	composer install

.PHONY: fmt
fmt: vendor ## Format code using php-cs-fixer
	vendor/bin/php-cs-fixer fix -v --using-cache=no

.PHONY: fmtcheck
fmtcheck: vendor ## Check code formatting
	vendor/bin/php-cs-fixer fix -v --using-cache=no --dry-run

.PHONY: docs
docs: vendor ## Generate API reference using phpDocumentor
	docker run --rm -v "$(CURDIR):/data" "phpdoc/phpdoc:3"

.PHONY: test
test: vendor ## Run PHPUnit test suite
	composer test

.PHONY: generate
generate: ## Generate SDK from the local OpenAPI specs
	cd codegen && go run ./... generate ../openapi.json ../src
