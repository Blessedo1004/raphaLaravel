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
    gettext

# Install PHP extensions (Postgres only)
RUN docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . /var/www

# Copy nginx TEMPLATE (important)
COPY docker/nginx/nginx.conf.template /etc/nginx/http.d/default.conf.template

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Make entrypoint executable (build-time, correct)
RUN chmod +x /usr/local/bin/entrypoint.sh

# Required dirs + permissions
RUN mkdir -p /run/nginx /var/log/nginx \
 && chown -R www-data:www-data /var/www

# DO NOT hardcode ports for Render
# NO EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
