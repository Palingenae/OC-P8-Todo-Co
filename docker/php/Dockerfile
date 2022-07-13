FROM php:7.2.34-apache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y \
    libzip-dev \
    wget \
    git && \
    pecl install apcu && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install zip && \
    docker-php-ext-enable apcu && \
    apt-get clean

COPY --from=composer:2.2.14 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY --chown=1000:1000 application /var/www/html

RUN mkdir -p /.composer/cache && chown -R 1000:1000 /.composer

ADD docker/php/conf/apache/000-default.conf /etc/apache2/sites-enabled/

ENV PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/var/www/html/vendor/bin

