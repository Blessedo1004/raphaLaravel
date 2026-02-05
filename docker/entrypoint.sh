#!/bin/sh
set -e

# -------------------------------
# Step 1: Run Laravel migrations
# -------------------------------
echo "Running database migrations..."
php artisan migrate --force

# Seed the database if not in production
if [ "$APP_ENV" != "production" ]; then
    echo "Seeding database..."
    php artisan db:seed
fi

# -------------------------------
# Step 2: Optimize Laravel
# -------------------------------
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# -------------------------------
# Step 3: Start Nginx + PHP-FPM
# -------------------------------
echo "--- NGINX CONFIG DEBUG ---"
echo "Render PORT: ${PORT}"

# Generate Nginx config with Render PORT
envsubst < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf

echo "Generated Nginx config:"
cat /etc/nginx/http.d/default.conf
echo "--- END NGINX CONFIG DEBUG ---"

# Fix Laravel permissions
chmod -R 775 storage bootstrap/cache || true

# Start PHP-FPM in background
php-fpm &

# Start Nginx in foreground
nginx -g "daemon off;"
