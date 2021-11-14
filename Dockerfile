# BASE
FROM php:8.0-fpm-buster as base

WORKDIR /usr/app

COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions apcu bz2 opcache pdo_pgsql zip
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    unzip \
    mariadb-client \
    git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

ENV PATH="/usr/app/vendor/bin:/usr/app/bin:${PATH}"

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY etc/docker/php-fpm/extra.ini /usr/local/etc/php/conf.d/extra.ini
COPY etc/docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# FPM-DEV
FROM base as fpm-dev

RUN install-php-extensions pcov xdebug

CMD ["php-fpm", "--allow-to-run-as-root"]
