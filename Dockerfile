FROM node:14.17-alpine as frontend
WORKDIR /var/www
COPY package*.json webpack.mix.js /var/www/
RUN npm install
COPY /resources/ /var/www/resources
RUN npm run dev && mkdir -p public/tests/images


FROM composer:2.1.3 as backend
WORKDIR /var/www/
COPY artisan composer.* /var/www/
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-autoloader \
    --prefer-dist


FROM atlastechnologiesteam/cate_base:latest as fm-cate
WORKDIR /var/www
COPY --from=frontend /var/www/public /var/www/public
COPY --from=backend /var/www/vendor /var/www/vendor
COPY . /var/www/
RUN ln -sf .env.example .env \
&&  composer dump-autoload
