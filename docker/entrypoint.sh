#!/bin/sh
set -e

echo "--- Render PORT: ${PORT} ---"

# Generate nginx config
envsubst < /etc/nginx/http.d/default.conf.template \
         > /etc/nginx/http.d/default.conf

# Laravel setup
php artisan key:generate --force || true
php artisan migrate --force || true
php artisan config:clear
php artisan route:clear
php artisan view:clear
chmod -R 775 storage bootstrap/cache || true

# Start PHP-FPM
php-fpm &

# Start Nginx
nginx -g "daemon off;"
