ARG LARAVEL_PATH=/var/www/html
FROM node:16.13.0 AS node

COPY yarn.lock $LARAVEL_PATH
COPY package.json $LARAVEL_PATH

RUN yarn install
COPY . $LARAVEL_PATH

RUN yarn production
COPY . $LARAVEL_PATH

FROM composer:2.1.11 AS composer
ARG LARAVEL_PATH

COPY composer.json $LARAVEL_PATH
COPY composer.lock $LARAVEL_PATH
RUN composer install --working-dir $LARAVEL_PATH --ignore-platform-reqs --no-progress --no-autoloader --no-scripts

COPY . $LARAVEL_PATH
COPY .env.production $LARAVEL_PATH/.env
RUN composer install --working-dir $LARAVEL_PATH --ignore-platform-reqs --no-progress --optimize-autoloader

FROM php:8.0-apache
ARG LARAVEL_PATH

COPY --from=node . $LARAVEL_PATH

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install \
        gd \
        pdo_mysql \
        zip

ENV APACHE_DOCUMENT_ROOT $LARAVEL_PATH/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN mkdir -p /root/.composer
COPY --from=composer /tmp/cache /root/.composer/cache
COPY --from=composer $LARAVEL_PATH $LARAVEL_PATH

RUN chown -R www-data $LARAVEL_PATH/storage

WORKDIR $LARAVEL_PATH