FROM php:8.0-apache

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli

COPY ./src /var/www/html
COPY ./apache-config.conf /etc/apache2/conf-enabled/apache-config.conf


COPY ./setup.sql /docker-entrypoint-initdb.d/setup.sql

EXPOSE 80
