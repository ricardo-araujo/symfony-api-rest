FROM php:7.4-fpm

MAINTAINER Ricardo Araujo

COPY . /www/symfony-api-rest

WORKDIR /www/symfony-api-rest

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    vim \
    git \
    libpq-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-enable pdo_mysql

