#!/bin/bash
set -e

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force
php artisan config:cache
php artisan route:cache
php artisan migrate --force

php-fpm &
nginx -g "daemon off;"