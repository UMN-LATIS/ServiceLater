#!/bin/sh

yes | php artisan migrate
apache2-foreground
