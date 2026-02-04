# Stage 1: Build frontend assets
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Setup backend with PHP, Nginx, and system dependencies
FROM php:8.2-fpm-alpine AS backend

# Install system dependencies including Nginx and common PHP extensions
RUN apk update && apk add --no-cache \
    nginx \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libexif-dev \
    oniguruma-dev \
    libpq-dev \
    # Extra dependencies for specific extensions
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy application files from the current directory into the container
COPY . .

# Copy built frontend assets from the 'frontend' stage
# Ensure the path matches your vite.config.js output directory
COPY --from=frontend /app/public/build ./public/build

# Copy Nginx configuration and the entrypoint script
COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Install PHP dependencies for production
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Set correct file permissions for Laravel to be able to write logs and cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 80 for Nginx
EXPOSE 80

# Set the entrypoint to our custom script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
