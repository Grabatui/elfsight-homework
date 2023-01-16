FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libpq-dev \
    && pecl install xdebug-3.0.1 \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable xdebug

WORKDIR /app
