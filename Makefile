########################################################################################################################
### Loading main ENV file
########################################################################################################################
include .env
export $(shell sed 's/=.*//' .env)
export COMPOSE_PROJECT_NAME=infrastructure-monitor

########################################################################################################################
### Makefile tasks
########################################################################################################################

# Main application build entrypoint
build:
	@mkdir -p database/postgresql/volume
	@docker run --rm \
           -u "$(id -u):$(id -g)" \
           -v .:/var/www/html \
           -w /var/www/html \
           serversideup/php:8.2-cli \
           composer install
	@docker run --rm \
           -u "$(id -u):$(id -g)" \
           -v .:/var/www/html \
           -w /var/www/html \
           serversideup/php:8.2-cli \
           php artisan key:generate --force
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		build --no-cache

# Resets application database, feeding it with default data
run-fresh-migrations:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		exec php bash -ci 'php artisan migrate:fresh --seed'

# Runs all new migrations
run-migrations:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		exec php bash -ci 'php artisan migrate'

# Spawns a new Tinker session
run-tinker:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		exec php bash -ci 'php artisan tinker'

# Runs Laravel Pint to properly format the code
sources-cleanup:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		exec php bash -ci 'composer lint'

# Updates all composer dependencies
do-composer-update:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		exec php bash -ci 'composer update'

# Generates a new user with administrative privileges
admin-user:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		exec php bash -ci 'php artisan make:admin-user'

# Boots up the application as daemon
up-d:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		up -d

# Boots up the application
up:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		up

# Shutdown the whole application
down:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		down

# Connects to main container shell in order to run commands
tty:
	@docker compose \
		-f docker/docker-compose.yml \
		-f docker/docker-compose.$(APP_ENV).yml \
		exec php bash

# Destroys database container volume
reset-db: down
	@echo "Turned down your running environment (if any).."
	@echo "Removing database volume.."
	@rm -rf docker/database/postgresql/volume
	@mkdir -p docker/database/postgresql/volume
	@echo "Database successfully removed, will be recreated on next application startup!"
