ARG PHP_VERSION=8.2
FROM --platform=linux/amd64 serversideup/php:${PHP_VERSION}-fpm-nginx-v2.2.1

# Install missing software
ARG NODE_MAJOR=20
ARG PHP_VERSION
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
      build-essential git vim ca-certificates curl gnupg \
      php${PHP_VERSION}-gd php${PHP_VERSION}-imagick \
      php${PHP_VERSION}-xml php${PHP_VERSION}-dev php${PHP_VERSION}-pgsql \
      php${PHP_VERSION}-curl php${PHP_VERSION}  php${PHP_VERSION}-common \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Set PHP_INI_DIR for docker-php-ext-enable to use
ARG PHP_VERSION
ENV PHP_INI_DIR=/etc/php/${PHP_VERSION}/fpm
