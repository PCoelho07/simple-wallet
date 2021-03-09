#!/bin/bash

while [ true ];
    do
        cd /var/www/app
        php artisan scheduler:run --verbose --no-interaction &
        sleep 60
done
