#!/bin/bash

FILE="/app/.env"

if [ ! -f ${FILE} ]
then
    cp ./.env.example ./.env
    composer update
    php artisan key:generate
fi

/usr/local/sbin/php-fpm --allow-to-run-as-root