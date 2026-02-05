#!/bin/sh
set -e

echo "--- Starting Laravel setup ---"

# Run migrations
php artisan migrate --force

# Run seeders only if not in production
if [ "$APP_ENV" != "production" ]; then
    php artisan db:seed
fi

# Clear and cache configs for production
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Starting PHP-FPM and Nginx ---"

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g 'daemon off;'
