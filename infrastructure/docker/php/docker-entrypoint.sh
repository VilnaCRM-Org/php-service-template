#!/bin/sh
set -e

if [ "${1#-}" != "$1" ]; then
    set -- frankenphp run --config /etc/caddy/Caddyfile "$@"
fi

if [ "$1" = 'frankenphp' ] && [ "${2:-}" = 'run' ] && [ "$APP_ENV" != 'prod' ] && [ -z "${CI:-}" ]; then
    case " $* " in
        *" --watch "*) ;;
        *) set -- "$@" --watch ;;
    esac
fi

if [ "$1" = 'frankenphp' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then
    install_dependencies=true

    if [ -f vendor/autoload.php ] \
        && [ ! composer.lock -nt vendor/autoload.php ] \
        && [ ! composer.json -nt vendor/autoload.php ]; then
        install_dependencies=false
    fi

    if [ "$install_dependencies" = 'true' ] && [ "$APP_ENV" != 'prod' ]; then
        composer install --prefer-dist --no-progress --no-interaction
    elif [ "$install_dependencies" = 'true' ]; then
        composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction
    fi

    if grep -q '^DB_URL=.*' .env; then
        echo "Waiting for database to be ready..."
        ATTEMPTS_LEFT_TO_REACH_DATABASE=60
        until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(php bin/console dbal:run-sql -q "SELECT 1" 2>&1); do
            if [ $? -eq 255 ]; then
                ATTEMPTS_LEFT_TO_REACH_DATABASE=0
                break
            fi
            sleep 1
            ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
            echo "Still waiting for database to be ready... Or maybe the database is not reachable. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left."
        done

        if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
            echo "The database is not up or not reachable:"
            echo "$DATABASE_ERROR"
            exit 1
        else
            echo "The database is now ready and reachable"
        fi

        if [ "$(find ./migrations -iname '*.php' -print -quit)" ]; then
            bin/console doctrine:migrations:migrate --no-interaction
        fi
    fi

    if [ -d var ] && [ "$(id -u)" -eq 0 ]; then
        setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
        setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var
    fi
fi

exec docker-php-entrypoint "$@"
