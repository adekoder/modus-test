FROM php:7.2-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick mcrypt-1.0.1 \
    && docker-php-ext-enable imagick mcrypt \
    && docker-php-ext-install  pdo_mysql 
