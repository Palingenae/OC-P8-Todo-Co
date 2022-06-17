FROM php:8.1.7-fpm

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    wget \
    git && \
    pecl install apcu && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install zip && \
    docker-php-ext-enable apcu

COPY --from=composer:2.3.7 /usr/bin/composer /usr/local/bin/composer

WORKDIR /usr/src/app

COPY --chown=1000:1000 application /usr/src/app

RUN mkdir -p /.composer/cache && chown -R 1000:1000 /.composer

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

USER 1000:1000