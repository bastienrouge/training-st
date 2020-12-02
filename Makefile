SYMFONY=symfony
CONSOLE=${SYMFONY} console
PHP=${SYMFONY} php
COMPOSER=${SYMFONY} composer
YARN=yarn

.PHONY: install env vendor db db-create node-modules assets
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
install: env vendor db node-modules assets ## Install the whole project
	@echo "\n\033[35m* Project ready\033[0m"
	@echo "\033[35m\n-> Try a \033[34mmake start\033[35m, then \033[34mmake browse\033[0m.\033[0m"

env: ./.env ## Create the .env.local file
	@echo "\n\033[35m* Creating .env.local file\033[0m"
	@cp ./.env ./.env.local

vendor: ./composer.json ## Install PHP dependencies
	@echo "\n\033[35m* Installing PHP dependencies\033[0m"
	@$(COMPOSER) install --prefer-dist --no-progress --quiet

db: vendor db-create ## Deploy the database

db-create: ## Only create the database
	@echo "\n\033[35m* Creating the database\033[0m"
	@$(CONSOLE) doctrine:database:create

node-modules:
	@echo "\n\033[35m* Installing JS dependencies\033[0m"
	@$(SYMFONY) run yarn

assets: node-modules
	@echo "\n\033[35m* Deploying web assets\033[0m"
	@$(SYMFONY) run yarn encore dev
