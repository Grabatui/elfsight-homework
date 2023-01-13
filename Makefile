up: docker-up
init: docker-down-clear docker-pull docker-build docker-up project-init
test: project-test
migrations: project-migrations

project-init: project-composer-install project-generate-keys

project-composer-install:
	docker-compose run --rm php-cli composer install

project-generate-keys:
	docker-compose run --rm php-cli php bin/console lexik:jwt:generate-keypair --skip-if-exists

project-test:
	docker-compose run --rm php-cli php bin/phpunit

project-migrations:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

docker-exec:
	docker-compose run --rm php-cli /bin/bash