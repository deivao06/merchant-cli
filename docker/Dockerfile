FROM php:8.3-cli

ARG UID=1000
ARG GID=1000

RUN groupadd -g $GID appuser && \
    useradd -u $UID -g appuser -m appuser && \
    chown -R appuser:appuser /var/www

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libonig-dev procps \
    && docker-php-ext-install pdo pdo_mysql zip pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV PATH="/root/.composer/vendor/bin:${PATH}"

WORKDIR /var/www/html/src
