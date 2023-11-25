FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt update && apt install -y \
    git \
    unzip \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libonig-dev \
    grep \
    curl \
    gnupg2

# RUN rm -rf /var/lib/apt/lists/*


RUN apt install -y nodejs npm


RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install pdo pdo_mysql mbstring gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


COPY .  /var/www/html/

RUN composer install


RUN php artisan key:generate

RUN php artisan storage:link

RUN npm install

ARG USER=root

RUN chown -R $USER:www-data storage
RUN chown -R $USER:www-data bootstrap/cache

RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap/cache

RUN php artisan route:clear
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan optimize



# CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000

CMD [ "php-fpm" ]

