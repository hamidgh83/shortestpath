FROM php:7.4.12-fpm-buster

RUN apt update && apt install -y sqlite3 git

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /usr/share/nginx/html

COPY . .

RUN composer update

EXPOSE 9000

COPY config/www.conf /usr/local/etc/php-fpm.d/

CMD php-fpm
