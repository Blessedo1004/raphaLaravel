# Stage 1: Build frontend assets
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Backend with PHP + Nginx
FROM php:8.2-fpm-alpine AS backend

# Install system dependencies including Nginx and PHP extensions
RUN apk add --no-cache \
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
    gettext \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl gd

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel app
COPY . .

# Copy built frontend assets
COPY --from=frontend /app/public/build ./public/build

# Copy Nginx template and entrypoint
COPY docker/nginx/nginx.conf.template /etc/nginx/http.d/default.conf.template
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Install PHP dependencies for production
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Set permissions for Laravel
RUN chown -R nginx:nginx storage bootstrap/cache \
 && mkdir -p /run/nginx /var/log/nginx

# Ensure PHP-FPM listens on TCP 127.0.0.1:9000
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf

# Expose port 80 (Render will map $PORT)
EXPOSE 80

# ENTRYPOINT
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
