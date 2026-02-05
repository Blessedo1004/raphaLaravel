# Stage 1: Build frontend assets
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Backend
FROM php:8.2-fpm-alpine AS backend

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

COPY --from=frontend /app/public/build ./public/build

COPY docker/nginx/nginx.conf.template /etc/nginx/http.d/default.conf.template
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

RUN chown -R nginx:nginx storage bootstrap/cache
RUN mkdir -p /run/nginx /var/log/nginx

RUN sed -i 's/^user = .*/user = nginx/' /usr/local/etc/php-fpm.d/www.conf \
 && sed -i 's/^group = .*/group = nginx/' /usr/local/etc/php-fpm.d/www.conf

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
