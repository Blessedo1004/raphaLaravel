#!/bin/sh
set -e

echo "--- Render PORT: ${PORT} ---"

# Generate nginx config with Render's PORT
envsubst < /etc/nginx/http.d/default.conf.template \
         > /etc/nginx/http.d/default.conf

echo "--- Generated nginx config ---"
cat /etc/nginx/http.d/default.conf
echo "-----------------------------"

# Laravel setup
php artisan key:generate --force || true
php artisan migrate --force || true
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Laravel permissions
chmod -R 775 storage bootstrap/cache || true

# Start PHP-FPM (socket mode)
php-fpm &

# Start Nginx (foreground)
nginx -g "daemon off;"
