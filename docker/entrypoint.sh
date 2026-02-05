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

#!/bin/sh
set -e

echo "--- NGINX CONFIG DEBUG ---"
echo "Render PORT: ${PORT}"

# Generate nginx config with Render's PORT
envsubst < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf

echo "Generated Nginx config:"
cat /etc/nginx/http.d/default.conf
echo "--- END NGINX CONFIG DEBUG ---"

# Fix Laravel permissions
chmod -R 775 storage bootstrap/cache || true

# Start PHP-FPM
php-fpm &

# Start Nginx (foreground)
nginx -g "daemon off;"

