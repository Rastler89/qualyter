FROM php:8.0-fpm-alpine

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install