SHELL=/bin/bash

SWARM_MODE := $(shell docker info --format '{{.Swarm.ControlAvailable}}')
UID := 1000

up:
	env UID=${UID} docker-compose up -d --build --remove-orphans

migrate:
	env UID=${UID} docker-compose exec app php artisan migrate

migrate-refresh:
	env UID=${UID} docker-compose exec app php artisan migrate:refresh

test:
	env UID=${UID} docker-compose exec app php artisan test

init:
	env UID=${UID} docker-compose exec app cp ./'.env.example' ./'.env'
	env UID=${UID} docker-compose exec app composer install --no-scripts --no-interaction --optimize-autoloader  --ignore-platform-reqs
	env UID=${UID} docker-compose exec app chmod -R 777 ./storage
	env UID=${UID} docker-compose exec app php artisan jwt:secret -n



