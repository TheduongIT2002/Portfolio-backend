# Dockerfile cho Laravel (PHP 8.2)
FROM php:8.2-fpm

# Cài các package cần thiết
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip exif gd

# Cài Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files trước để cache build nhanh hơn
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Copy toàn bộ source
COPY . .

# Set quyền
RUN chown -R www-data:www-data /var/www && chmod -R 775 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
