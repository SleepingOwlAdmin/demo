#!/usr/bin/env sh

set -e

while [ true ]
do
    php /app/artisan schedule:run --verbose --no-interaction &
    sleep 60
done