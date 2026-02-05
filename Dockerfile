# Use PHP CLI Alpine
FROM php:8.2-cli-alpine

# Install system dependencies
RUN apk add --no-cache bash git unzip libzip-dev

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose Render port
EXPOSE 10000

# Start Laravel built-in server on Render's $PORT
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=$PORT"]
