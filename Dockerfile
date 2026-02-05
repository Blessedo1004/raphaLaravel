FROM php:8.2-cli-alpine

RUN apk add --no-cache bash git unzip libzip-dev \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=$PORT"]
