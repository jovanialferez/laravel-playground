FROM laravelsail/php74-composer AS composer

COPY . /opt
WORKDIR /opt
RUN composer install

FROM node:12-alpine AS node

COPY . /usr/src/app
WORKDIR /usr/src/app
RUN npm install && npm run prod

FROM php:7.4-apache

RUN sed -i -e "s/html/html\/public/g" \
    /etc/apache2/sites-enabled/000-default.conf

RUN a2enmod rewrite

COPY . /var/www/html
COPY --from=composer /opt/vendor /var/www/html/vendor
COPY --from=node /usr/src/app/public/css /var/www/html/public/css
COPY --from=node /usr/src/app/public/js /var/www/html/public/js

RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache

COPY docker.env /var/www/html/.env

VOLUME ["/var/www/html/storage", "/var/www/html/bootstrap/cache"]