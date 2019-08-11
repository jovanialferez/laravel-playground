FROM php:fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN addgroup --gid 1000 -S www && adduser -S --uid 1000 www -G www

COPY --chown=www:www . /var/www

USER www