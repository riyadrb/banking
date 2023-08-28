FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt update && apt install -y \
    git \
    unzip \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libonig-dev \
    grep

RUN rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql mbstring gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
COPY . .
RUN composer install

RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD [ "php-fpm" ]