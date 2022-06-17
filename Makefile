.PHONY:
env:			## Copy local .env.dist into a local .env
	cp -n .env.dist .env

.PHONY:
build:			## Build Docker containers (that needs to be built) in this folder
	docker-compose -f docker-compose.yml build --no-cache

.PHONY:
up:			## Start Docker containers in this folder
	docker-compose up -d

.PHONY:
restart:		## Restart Docker containers in this folder
	docker-compose restart

.PHONY:
stop:			## Stop Docker containers in this folder
	docker-compose stop

.PHONY:
composer-install: 	## Install PHP Dependencies
	docker-compose exec php composer install

.PHONY:
migration:		## Make a Doctrine migration
	docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

.PHONY:
dev:			## Create development environment
	env build up composer-install

.PHONY:
remove-dev:		## Delete the development environment
	docker-compose down

.PHONY:
reset-dev:		## Recreate development environment
	remove-dev build up composer-install

.PHONY:
phpstan:		## Use PHPStan command, to check your code.
	docker-compose exec php vendor/bin/phpstan analyse src

.PHONY:
phpcsfixer:		## Use PHP CS Fixer command.
	docker-compose exec php composer exec php-cs-fixer fix

.PHONY:
blackfire-curl:		## Make a curl request
	docker-compose exec blackfire blackfire curl 

help:			## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'
