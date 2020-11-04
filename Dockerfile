FROM composer:1.9 as vendor

COPY database/ database/

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist


FROM node:10.16.3-stretch as frontend
WORKDIR /app
RUN mkdir -p /app/public
COPY package-lock.json package.json webpack.mix.js /app/
RUN npm install
COPY resources /app/resources

COPY artisan /app

RUN npm run prod

FROM php:7.4-apache

COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=frontend /app/public/js/ /var/www/html/public/js/
COPY --from=frontend /app/public/css/ /var/www/html/public/css/
COPY --from=frontend /app/public/mix-manifest.json /var/www/html/public/mix-manifest.json
# COPY --from=frontend /app/node_modules/ /var/www/html/node_modules


ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "Listen 8080" >> /etc/apache2/ports.conf

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \ 
    && docker-php-ext-configure mysqli --with-mysqli \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-install mysqli pdo_mysql

COPY . /var/www/html

RUN chmod -R 777 /var/www/html/storage/
