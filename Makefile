UID ?= 1000
GID ?= 1000

THIS_FILE := $(lastword $(MAKEFILE_LIST))

# Shell access to app container.

.PHONY: picwork-bash
picwork-bash:
	docker-compose exec --user $(UID):$(GID) app bash


# Bring up/down services.

.PHONY: up
up: picwork-touch
	docker-compose up -d app

.PHONY: down
down:
	docker-compose down



# Create required directories and files in host machine.

.PHONY: picwork-touch
picwork-touch:
	cp -n ./app/.env.example ./app/.env
	touch ./app/storage/logs/laravel.log