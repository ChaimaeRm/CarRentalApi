# Variables
PHP_BIN = php
COMPOSER_BIN = composer
SYMFONY_BIN = symfony
PHP_CS_FIXER_BIN = ./vendor/bin/phpcs
PHP_CBF_FIXER_BIN = ./vendor/bin/phpcbf
PHPSTAN_BIN = ./vendor/bin/phpstan
CONSOLE = $(PHP_BIN) bin/console

# Default target
.DEFAULT_GOAL := help

## —— Installation ————————————————————————————————————————————————————————
init: install  database-create  database-update database_fixtures

install: ## Install the project dependencies
	$(COMPOSER_BIN) install

update: ## Update the project dependencies
	$(COMPOSER_BIN) update

## —— Quality Assurance ———————————————————————————————————————————————————

cs-fix: ## Fix PHP code style issues
	$(PHP_CS_FIXER_BIN) ./src --standard=PSR12
phpcbf:
	$(PHP_CBF_FIXER_BIN) ./src --standard=PSR12

## —— Symfony Server ——————————————————————————————————————————————————————
start: ## Start the Symfony server
	$(SYMFONY_BIN) serve -d

serve-stop: ## Stop the Symfony server
	$(SYMFONY_BIN) server:stop

## —— Database —————————————————————————————————————————————————————————
database-create: ## Create the database
	$(CONSOLE) doctrine:database:create

database-drop: ## Drop the database
	$(CONSOLE) doctrine:database:drop --force

database-update: ## Update the database schema
	$(CONSOLE) doctrine:schema:update --force

database_fixtures:
	$(CONSOLE) doctrine:fixtures:load -n
## —— Tests ————————————————————————————————————————————————————————————
test_prepare_database:
	$(CONSOLE) doctrine:database:create --env=test
	$(CONSOLE) doctrine:schema:update --force --env=test
	$(CONSOLE) doctrine:fixtures:load -n --env=test
test: ## Run the tests
	$(PHP_BIN) bin/phpunit