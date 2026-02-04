#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

# Run database migrations. The --force flag is important in production.
echo "Running database migrations..."
php artisan migrate --force

# Optimize Laravel application
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
nginx -g "daemon off;"
