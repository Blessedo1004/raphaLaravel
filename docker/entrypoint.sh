#!/bin/sh
set -e

# -------------------------------
# Step 0: Ensure PORT is exported
# -------------------------------
export PORT=${PORT:-80}
echo "Render PORT is $PORT"

# -------------------------------
# Step 1: Run Laravel migrations
# -------------------------------
echo "--- Running Laravel migrations ---"
php artisan migrate --force

if [ "$APP_ENV" != "production" ]; then
    echo "--- Seeding database ---"
    php artisan db:seed
fi

# -------------------------------
# Step 2: Cache Laravel config/routes/views
# -------------------------------
echo "--- Caching configuration, routes, views ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

# -------------------------------
# Step 3: Generate Nginx config
# -------------------------------
echo "--- Generating Nginx config ---"
envsubst '$PORT' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf

echo "Generated Nginx config:"
cat /etc/nginx/http.d/default.conf
echo "--- End of Nginx config ---"

# -------------------------------
# Step 4: Fix Laravel permissions
# -------------------------------
chmod -R 775 storage bootstrap/cache || true

# -------------------------------
# Step 5: Start PHP-FPM
# -------------------------------
echo "--- Starting PHP-FPM ---"
php-fpm &

# -------------------------------
# Step 6: Start Nginx (foreground!)
# -------------------------------
echo "--- Starting Nginx ---"
nginx -g "daemon off;"
