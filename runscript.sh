#!/bin/sh

yes | php artisan migrate
php artisan config:clear
php artisan cache:clear
php artisan config:cache
apache2-foreground
