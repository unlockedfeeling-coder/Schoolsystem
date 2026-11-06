FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring exif pcntl bcmath gd pdo pdo_mysql pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# This forces the server to ignore local files and use your Render settings
CMD ["sh", "-c", "touch .env && php artisan optimize:clear && php artisan migrate --no-interaction && php artisan serve --host=0.0.0.0 --port=$PORT"]