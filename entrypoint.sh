#!/bin/bash

# Enable verbose mode to show all commands being executed
set -x
set -ex
set -e

chown -R www-data:www-data /var/www/storage


if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist
fi

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

php artisan key:generate

if [ ! -f /var/www/storage/.migrations_done ]; then
    echo "Running migrations..."
    php artisan migrate:fresh --seed --force  

    touch /var/www/storage/.migrations_done
fi

exec php-fpm