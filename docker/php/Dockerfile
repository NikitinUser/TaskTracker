FROM php:8.1.16-fpm

USER root

WORKDIR /var/www/html

RUN docker-php-ext-install \
    pdo_mysql

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
