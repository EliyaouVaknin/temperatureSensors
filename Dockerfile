FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip curl libpq-dev libzip-dev libssl-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY ./app /var/www

RUN composer install

EXPOSE 8080
# CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
