FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p    /var/www/storage/framework/cache \
                /var/www/storage/framework/sessions \
                /var/www/storage/framework/views \
                /var/www/bootstrap/cache && \
    
    chown -R www-data:www-data  /var/www/storage \
                                /var/www/bootstrap/cache && \
    
    chmod -R 775                /var/www/storage \
                                /var/www/bootstrap/cache

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-autoloader --no-scripts --no-interaction
COPY . .
RUN composer dump-autoload --optimize && \
    php artisan package:discover --ansi



COPY docker/php/startup.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/startup.sh
ENTRYPOINT ["startup.sh"]
CMD ["php-fpm"]