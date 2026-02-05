#!/bin/sh
set -e

echo "--- Render PORT: ${PORT} ---"

# Generate nginx config with Render's PORT
envsubst < /etc/nginx/http.d/default.conf.template \
         > /etc/nginx/http.d/default.conf

echo "--- Generated nginx config ---"
cat /etc/nginx/http.d/default.conf
echo "-----------------------------"

# Laravel setup (safe on every boot)
php artisan key:generate --force || true
php artisan migrate --force || true
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start PHP-FPM
php-fpm &

# Start nginx (FOREGROUND, LAST)
nginx -g "daemon off;"
