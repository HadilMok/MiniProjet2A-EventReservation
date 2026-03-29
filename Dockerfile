FROM php:8.2-fpm
RUN apt-get update && apt-get install -y libicu-dev libzip-dev zip && \
    docker-php-ext-install intl pdo pdo_mysql zip
WORKDIR /var/www/html
