FROM php:7.0-fpm

ENV DEBIAN_FRONTEND noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
  && docker-php-ext-install pdo_mysql mysqli

#COPY ./src /var/www/html
WORKDIR /var/www/html
