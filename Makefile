.PHONY: up down setup test

up:
	docker-compose up -d

down:
	docker-compose down

setup:
	docker-compose exec app composer install
	docker-compose exec app php vendor/bin/doctrine orm:schema-tool:create

test:
	docker-compose exec app php vendor/bin/phpunit tests/Unit
