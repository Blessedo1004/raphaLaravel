# Use PHP-FPM Alpine
FROM php:8.2-fpm-alpine

# Install system packages
RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    gettext \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libexif-dev \
    oniguruma-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl gd

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies (production)
RUN composer install --no-dev --optimize-autoloader

# Copy Nginx TEMPLATE (important)
COPY docker/nginx/nginx.conf.template /etc/nginx/http.d/default.conf.template

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create required dirs + permissions
RUN mkdir -p /run/nginx /var/log/nginx \
 && chown -R www-data:www-data /var/www

# Expose (Render injects PORT, so no hardcoded port)
# EXPOSE 80   # optional, Render auto-detects

# Start container
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
