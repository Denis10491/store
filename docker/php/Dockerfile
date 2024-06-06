FROM php:8.3-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction && \
    composer dump-autoload --optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    chown -R www-data:www-data /var/www/html/fakestore && \
    chmod 777 -R /var/www/html/fakestore/storage && \
    a2enmod rewrite

RUN apt-get update && apt-get install -y curl wget git libfreetype6-dev libjpeg62-turbo-dev \
    libpng-dev libonig-dev libzip-dev libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install mcrypt && docker-php-ext-enable mcrypt \
    && pecl install redis && docker-php-ext-enable redis \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

WORKDIR /var/www/html/fakestore

VOLUME /var/www/html/fakestore

CMD ["php-fpm"]
