#!/bin/sh

# Exit immediately if a command exits with a non-zero status.
set -e

# Run database migrations. The --force flag is important in production.
echo "Running database migrations..."
php artisan migrate --force

# Seed the database if not in production
if [ "$APP_ENV" != "production" ]; then
    echo "Seeding database..."
    php artisan db:seed
fi


# Optimize Laravel application
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in the background
php-fpm -D

# Process Nginx configuration template
echo "Processing Nginx configuration template..."
envsubst '$PORT' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf

# Start Nginx in the foreground
nginx -g "daemon off;"
