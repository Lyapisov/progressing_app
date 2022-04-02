FROM php:8.0-cli-alpine

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
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

WORKDIR /app

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

RUN adduser --uid 1000 --disabled-password userapp

RUN mkdir -p /home/userapp/.composer \
   && chown -R userapp /home/userapp/.composer \
   && chgrp -R userapp /home/userapp/.composer

USER userapp
