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

# This line creates the .env file so artisan commands don't crash, then runs migrations
CMD ["sh", "-c", "cp .env.example .env && php artisan config:clear && php artisan migrate --no-interaction && php artisan serve --host=0.0.0.0 --port=$PORT"]