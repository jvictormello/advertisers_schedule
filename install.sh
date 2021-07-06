#!/bin/sh

PROJECT="cate-app"
color='\033[1;36m'

echo  "${color}++++++++ Iniciando instalação ++++++++++++++++"
docker docker-compose up -d
docker exec -it ${PROJECT} composer install
docker exec -it ${PROJECT} npm install
docker exec -it ${PROJECT} npm run dev
docker exec -it ${PROJECT} cp .env.example .env
docker exec -it ${PROJECT} php artisan key:generate
docker exec -it ${PROJECT} rm public/storage
docker exec -it ${PROJECT} php artisan storage:link

echo  "${color}++++++++ Instalação concluida ++++++++++++++++"
