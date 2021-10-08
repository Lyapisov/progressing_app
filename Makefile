connect-php-fpm: ## Connect php-fpm
	docker-compose exec php-fpm bash

connect-php-cli: ## run command and remove php-cli
	docker-compose run --rm php-cli -v

connect-app: ## Connect to container contained Angular App
	docker-compose exec node-angular bash

init-dev: env-dev docker-down-clear docker-pull docker-build docker-up app-init ## Initialize project
restart: docker-down docker-up
build-production: build-gateway build-frontend build-backend
push-production: push-gateway push-frontend push-backend

docker-build:
	docker-compose build

docker-pull:
	docker-compose pull

docker-up:
	docker-compose up -d

app-init: ## Deploy last version
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli bin/console d:m:m -e dev --no-interaction

env-dev:
	cp -n .env.dist .env

run-tests: ## Start tests
	docker-compose run --rm php-cli php -d memory_limit=2G bin/phpunit

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

build-gateway:
	docker build --pull --file=gateway/docker/production/nginx/Dockerfile --tag ${REGISTRY_ADDRESS}/progressing-app-gateway:${IMAGE_TAG} gateway

build-frontend:
	docker build --pull --file=frontend/docker/production/nginx/Dockerfile --build-arg BACKEND_API_URL=${BACKEND_API_URL} --tag ${REGISTRY_ADDRESS}/progressing-app-frontend:${IMAGE_TAG} frontend

build-backend:
	docker build --pull --file=backend/docker/production/nginx/Dockerfile --tag ${REGISTRY_ADDRESS}/progressing-app-backend:${IMAGE_TAG} backend
	docker build --pull --file=backend/docker/production/php-fpm/Dockerfile --tag ${REGISTRY_ADDRESS}/progressing-app-backend-php-fpm:${IMAGE_TAG} backend
	docker build --pull --file=backend/docker/production/php-cli/Dockerfile --tag ${REGISTRY_ADDRESS}/progressing-app-backend-php-cli:${IMAGE_TAG} backend

try-build:
	REGISTRY_ADDRESS=localhost IMAGE_TAG=0 make build

push-gateway:
	docker push ${REGISTRY_ADDRESS}/progressing-app-gateway:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY_ADDRESS}/progressing-app-frontend:${IMAGE_TAG}

push-backend:
	docker push ${REGISTRY_ADDRESS}/progressing-app-backend:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}/progressing-app-backend-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}/progressing-app-backend-php-cli:${IMAGE_TAG}

