.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

build_frontend: ## Install all dependecies frontend
	@docker-compose up -d
	@docker-compose exec cate-app npm install
	@docker-compose exec cate-app npm run prod

build_backend: ## Install all dependecies backend
	@docker-compose up -d
	@docker-compose exec cate-app composer install

start: ## Start containers
	@docker-compose up -d --build
	@docker-compose exec cate-app ln -sf .env.example .env
	@docker-compose exec cate-app npm install
	@docker-compose exec cate-app npm run prod
	@docker-compose exec cate-app composer install
	@docker-compose exec cate-app php artisan migrate

retart: ## Retart containers
	@docker-compose up -d --build --force-recreate
