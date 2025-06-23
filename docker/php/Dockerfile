# Stage 1: Node.js for assets
FROM node:18 as node
WORKDIR /var/www
COPY package.json package-lock.json ./
RUN npm install

# Stage 2: PHP
FROM php:8.2-fpm
COPY --from=node /var/www/node_modules /var/www/node_modules

ENV NPM_CONFIG_CACHE=/tmp/.npm
RUN mkdir -p /tmp/.npm && chown -R www-data:www-data /tmp/.npm


RUN mkdir -p /var/www/node_modules/.vite \
    && chown -R www-data:www-data /var/www/node_modules \
    && chmod -R 775 /var/www/node_modules

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    gnupg \
    ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
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

RUN chown www-data:www-data /var/www

COPY --chown=www-data:www-data ./ .

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-autoloader --no-scripts --no-interaction
COPY . .
RUN composer dump-autoload --optimize && \
    php artisan package:discover --ansi


COPY docker/php/startup.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/startup.sh
ENTRYPOINT ["startup.sh"]
CMD ["php-fpm"]