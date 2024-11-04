FROM php:8.0-apache

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

COPY ./src /var/www/html
COPY ./apache-config.conf /etc/apache2/conf-enabled/apache-config.conf

EXPOSE 80
