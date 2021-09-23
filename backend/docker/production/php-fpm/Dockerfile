####################### builder image
FROM php:8.0-cli-alpine AS builder

RUN apk add --update unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /root/.composer/cache
RUN composer --version
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app

COPY ./composer.json ./composer.lock ./auth.json ./

RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader \
    && rm -rf /root/.composer/cache

####################### origins image
FROM php:8.0-fpm-alpine

RUN apk add --update --no-cache unzip \
    postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql

RUN adduser -D -u 1000 appuser

WORKDIR /app

COPY --from=builder /app ./
COPY . ./

RUN mkdir -p /app/var && chown -R appuser:appuser /app/var

USER appuser
