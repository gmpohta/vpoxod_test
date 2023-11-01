up:
	docker compose up -d --build --force-recreate

down:
	docker compose down

build: up
	docker compose run --rm php-fpm composer install --no-interaction -o

lint:
	docker compose run --rm php-fpm composer lint

test:
	docker compose run --rm php-fpm composer test