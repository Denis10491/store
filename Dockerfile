FROM composer:2.7.4 as build
WORKDIR /app
COPY . .
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

FROM php:8.3-apache
ENV APP_ENV=dev
ENV APP_DEBUG=true
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y zip
RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=build /app/vendor /var/www/html/vendor
COPY . .
RUN composer dump-autoload --optimize

COPY docker/apache/apache-config.conf /etc/apache2/sites-available/000-default.conf
COPY .env /var/www/html/.env

RUN php artisan config:cache && \
    php artisan route:cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod 777 -R /var/www/html/storage/ && \
    a2enmod rewrite

EXPOSE 80
