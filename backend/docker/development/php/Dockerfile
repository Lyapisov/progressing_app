FROM php:8.0-fpm-alpine

RUN apk add --update --no-cache \
    icu \
    git \
    openssh-server \
    openssh-client \
    libzip \
    libzip-dev \
    zlib-dev \
    icu-dev \
    autoconf \
    g++ \
    make \
    && pecl install xdebug \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/pear

COPY ./xdebug.ini /usr/local/etc/php/conf.d

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /root/.composer/cache

WORKDIR /app

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

RUN adduser --uid 1000 --disabled-password userapp

RUN mkdir -p /home/userapp/.composer \
   && chown -R userapp /home/userapp/.composer \
   && chgrp -R userapp /home/userapp/.composer

USER userapp
