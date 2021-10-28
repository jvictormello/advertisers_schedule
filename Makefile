.PHONY: help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

install_frontend: up ## Install all dependecies frontend
	@docker-compose exec cate-app npm install


watch_frontend: up ## Watch file changes on frontend
	@docker-compose exec cate-app npm run watch
	

install_backend: up ## Install all dependecies backend
	@docker-compose exec cate-app ln -sf .env.example .env
	@docker-compose exec cate-app composer install
	
	
migrate: up ## Install all dependecies backend
	@docker-compose exec cate-app php artisan migrate

start: up install_frontend install_backend migrate ## Start services

up: ## Up all containers
	@docker-compose up -d --build
	
	
retart: ## Retart containers
	@docker-compose up -d --build --force-recreate
