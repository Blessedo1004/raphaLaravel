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
# --- DEBUGGING START ---
echo "--- NGINX CONFIG DEBUG ---"
echo "Current value of PORT: ${PORT}"
# Set PORT to 80 if it's not already defined for envsubst
export PORT=${PORT:-80}
echo "PORT value after default check: ${PORT}"
echo "Processing Nginx configuration template..."

# Check if the template file exists before trying to process it
if [ ! -f "/etc/nginx/http.d/default.conf.template" ]; then
    echo "ERROR: Nginx template file /etc/nginx/http.d/default.conf.template not found!"
    exit 1
fi

envsubst < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf

echo "Generated Nginx config (/etc/nginx/http.d/default.conf):"
cat /etc/nginx/http.d/default.conf
echo "--- END NGINX CONFIG DEBUG ---"

# Start Nginx in the foreground
nginx -g "daemon off;"
