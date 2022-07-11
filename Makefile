connect-php: ## Connect php
	docker-compose exec php sh

connect-app: ## Connect to container contained Angular App
	docker-compose exec frontend-node bash

init-dev: env-dev docker-down-clear docker-pull docker-build docker-up app-init ## Initialize project
restart: docker-down docker-up

docker-build:
	docker-compose build

docker-pull:
	docker-compose pull

docker-up:
	docker-compose up -d

#generate-jwt: ## Generate Jwt
#	docker-compose exec -T php sh -c ' \
#	php bin/console lexik:jwt:generate-keypair --no-interaction; \
#	setfacl -R -m u:www-data:rX -m u:"userapp":rwX config/jwt; \
#	setfacl -dR -m u:www-data:rX -m u:"userapp":rwX config/jwt'

app-init: ## Deploy last version
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli bin/console d:m:m -e dev --no-interaction

env-dev:
	cp -n .env.dist .env

run-tests: ## Start tests
	docker-compose run --rm php php -d memory_limit=2G bin/phpunit

docker-down: ## Stop container
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

init-dev-file-database:
	touch src/FilesDataBase/DataBase/UserAccess/Users/users.csv
	printf "id;login;email;password;role;registrationDate;annualToken \n" >> src/FilesDataBase/DataBase/UserAccess/Users/users.csv

init-test-file-database:
	touch src/FilesDataBase/DataBase/UserAccess/Users/TestBase/users-test.csv
	printf "id;login;email;password;role;registrationDate;annualToken \n" >> src/FilesDataBase/DataBase/UserAccess/Users/TestBase/users-test.csv

