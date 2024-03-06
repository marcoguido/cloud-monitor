ARG PHP_VERSION=8.2
FROM --platform=linux/amd64 serversideup/php:${PHP_VERSION}-cli-v2.2.1

# Install missing software
ARG PHP_VERSION
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
      ca-certificates curl gnupg \
      php${PHP_VERSION}-gd php${PHP_VERSION}-imagick \
      php${PHP_VERSION}-xml php${PHP_VERSION}-dev php${PHP_VERSION}-pgsql \
      php${PHP_VERSION}-curl  php${PHP_VERSION}-common \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
