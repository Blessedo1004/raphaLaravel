#!/bin/sh
set -e

# Replace environment variables in Nginx template
envsubst < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# Run migrations
php artisan migrate --force

# Run seeders if not production
if [ "$APP_ENV" != "production" ]; then
    php artisan db:seed
fi

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
php-fpm -D

# Start Nginx in foreground
nginx -g 'daemon off;'
