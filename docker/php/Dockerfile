FROM php:7.4.12-fpm-buster

RUN apt update && apt install -y sqlite3 unzip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

COPY docker/php/config/php.ini /usr/local/etc/php/

WORKDIR /var/www/shortestpath

COPY . . 

RUN composer update