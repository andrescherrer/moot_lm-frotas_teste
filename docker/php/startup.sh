#!/bin/bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize:clear
exec "$@"