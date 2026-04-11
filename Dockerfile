FROM composer/composer:2-bin AS composer
FROM mlocati/php-extension-installer:2.2 AS php_extension_installer

FROM dunglas/frankenphp:1-php8.3.17-alpine AS frankenphp_base

WORKDIR /srv/app

COPY --from=php_extension_installer --link /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache \
    acl \
    curl \
    file \
    gettext \
    git

ARG STABILITY=stable
ENV STABILITY=${STABILITY}

ARG SYMFONY_VERSION=""
ENV SYMFONY_VERSION=${SYMFONY_VERSION}

ENV APP_ENV=prod
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

RUN set -eux; \
    install-php-extensions \
        apcu \
        intl \
        opcache \
        openssl \
        pdo_pgsql \
        redis \
        xsl \
        zip

COPY --link infrastructure/docker/php/conf.d/app.ini $PHP_INI_DIR/conf.d/
COPY --link --chmod=755 infrastructure/docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
COPY --link infrastructure/docker/caddy/Caddyfile /etc/caddy/Caddyfile

ENTRYPOINT ["docker-entrypoint"]
HEALTHCHECK --start-period=60s CMD curl -fsS http://localhost:2019/metrics || exit 1

COPY --from=composer --link /composer /usr/bin/composer

COPY --link composer.* symfony.* ./
RUN set -eux; \
    if [ -f composer.json ]; then \
        composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress; \
        composer clear-cache; \
    fi

COPY --link . ./
RUN rm -Rf infrastructure/docker/

RUN set -eux; \
    mkdir -p var/cache var/log; \
    if [ -f composer.json ]; then \
        composer dump-autoload --classmap-authoritative --no-dev; \
        composer dump-env prod; \
        chmod +x bin/console; \
        sync; \
    fi

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]

FROM frankenphp_base AS frankenphp_dev

ENV APP_ENV=dev \
    XDEBUG_MODE=off

RUN apk add --no-cache \
    bash \
    bats \
    make

RUN curl -sS https://get.symfony.com/cli/installer | bash \
 && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
    install-php-extensions xdebug

COPY --link infrastructure/docker/php/conf.d/app.dev.ini $PHP_INI_DIR/conf.d/

RUN git config --global --add safe.directory /srv/app
RUN rm -f .env.local.php

FROM frankenphp_base AS frankenphp_prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --link infrastructure/docker/php/conf.d/app.prod.ini $PHP_INI_DIR/conf.d/

RUN mkdir -p /data /config /srv/app/var \
 && chown -R www-data:www-data /data /config /srv/app

USER www-data
