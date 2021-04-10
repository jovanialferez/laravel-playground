FROM node:12-alpine AS node

COPY . /usr/src/app
WORKDIR /usr/src/app
RUN npm install && npm run prod

FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    libpq-dev \
    pkg-config \
    patch \
	--no-install-recommends \
	&& apt-get purge --auto-remove -y curl gnupg \
	&& rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install gd zip pdo pdo_pgsql

RUN sed -i -e "s/html/html\/public/g" \
    /etc/apache2/sites-enabled/000-default.conf

RUN a2enmod rewrite

COPY --from=laravelsail/php74-composer /usr/bin/composer /usr/bin/composer
COPY . /var/www/html
COPY --from=node /usr/src/app/public/css /var/www/html/public/css
COPY --from=node /usr/src/app/public/js /var/www/html/public/js

COPY docker_startup.sh /usr/local/bin
RUN chmod +x /usr/local/bin/docker_startup.sh
WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache

VOLUME ["/var/www/html/storage", "/var/www/html/bootstrap/cache"]

CMD [ "docker_startup.sh" ]