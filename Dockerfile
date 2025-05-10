FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Add Redis extension (required for workers)
RUN pecl install redis && docker-php-ext-enable redis

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ./app /var/www

RUN composer install

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]

