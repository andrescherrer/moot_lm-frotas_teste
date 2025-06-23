#!/bin/bash
set -e

mkdir -p /var/www/storage/framework/{cache,sessions,views}
mkdir -p /var/www/bootstrap/cache

find /var/www/storage -type d -exec chmod 775 {} \; || true
find /var/www/bootstrap/cache -type d -exec chmod 775 {} \; || true

echo "foi"

exec "$@"
