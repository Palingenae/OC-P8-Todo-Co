FROM php:5.5.38-fpm

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y \
    libzip-dev \
    wget \
    git && \
    # pecl install apcu && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install zip && \
    # docker-php-ext-enable apcu
    apt-get clean

RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && architecture=$(uname -m) \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/$architecture/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8307\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz && \
    mkdir -p /tmp/blackfire \
    && architecture=$(uname -m) \
    && curl -A "Docker" -L https://blackfire.io/api/v1/releases/cli/linux/$architecture | tar zxp -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire /usr/bin/blackfire \
    && rm -Rf /tmp/blackfire

COPY --from=composer:2.2.14 /usr/bin/composer /usr/local/bin/composer

WORKDIR /usr/src/app

COPY --chown=1000:1000 application /usr/src/app

RUN mkdir -p /.composer/cache && chown -R 1000:1000 /.composer

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

USER 1000:1000