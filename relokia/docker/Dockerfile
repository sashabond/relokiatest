FROM php:7.4-fpm
RUN apt-get update && pecl install xdebug-3.0.1 && docker-php-ext-enable xdebug && curl -sS https://getcomposer.org/installer | php 
FROM composer:latest
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer require guzzlehttp/guzzle:^7.0
WORKDIR /app
CMD ["php-fpm"]