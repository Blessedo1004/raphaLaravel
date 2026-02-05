FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx bash curl zip unzip libzip-dev libpq-dev gettext git libpng-dev libjpeg-turbo-dev freetype-dev libexif-dev oniguruma-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl gd

WORKDIR /var/www
COPY . /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

COPY docker/nginx/nginx.conf.template /etc/nginx/http.d/default.conf.template
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN mkdir -p /run/nginx /var/log/nginx \
 && chown -R www-data:www-data /var/www

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
