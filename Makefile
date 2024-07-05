all: start

up:
	docker compose up -d

stop:
	docker compose stop

start:
	docker compose start

pint:
	docker compose exec application sh -c "php vendor/bin/pint"

test:
	docker compose exec application sh -c "php vendor/bin/phpunit"

test-coverage:
	docker compose exec application sh -c "php vendor/bin/phpunit --coverage-html=coverage"

phpstan:
	docker compose exec application sh -c "php vendor/bin/phpstan"

update:
	docker compose run composer sh -c "composer update"

update-lowest:
	docker compose run composer sh -c "composer update --prefer-lowest"

application:
	docker compose exec application sh

composer:
	docker compose run composer sh

permissions:
	docker compose exec application sh -c "chown 1000:1000 -R /app/"

restart: stop start
