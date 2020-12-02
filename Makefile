SYMFONY=symfony
CONSOLE=${SYMFONY} console
PHP=${SYMFONY} php
COMPOSER=${SYMFONY} composer

.PHONY: install env vendor db db-create
.DEFAULT_GOAL := help

##
###---------------------------#
###    Help                   #
###---------------------------#
##
help:   ## Display all help messages
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

.PHONY: help

##
###---------------------------#
###    Server commands       #
###---------------------------#
##
start: ## Run the the PHP server in background
	@$(SYMFONY) serve -d

stop: ## Stop your running server
	@$(SYMFONY) server:stop

status: ## Get status information on your server
	@$(SYMFONY) server:status

logs: ## Access your server logs
	@$(SYMFONY) server:log

browse: ## Open the app in your web browser
	@$(SYMFONY) open:local

##
###---------------------------#
###    Project commands       #
###---------------------------#
##
install: env vendor db ## Install the whole project

env: ./.env ## Create the .env.local file
	@echo "\033[35m* Creating .env.local file\033[0m\c"
	@cp ./.env ./.env.local && echo "     [OK]"

vendor: ./composer.json ## Install PHP dependencies
	@echo "\033[35m* Installing PHP dependencies\033[0m\c"
	@$(COMPOSER) install --prefer-dist --no-progress --quiet && echo "  [OK]"

db: vendor db-create ## Deploy the database

db-create: ## Only create the database
	@echo "\033[35m* Creating the database\033[0m"
	@$(CONSOLE) doctrine:database:create

