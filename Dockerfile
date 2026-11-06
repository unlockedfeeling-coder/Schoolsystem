FROM php:8.2-cli

# Install system dependencies and PHP extensions
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

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application code
COPY . .

# Install dependencies (ignoring platform reqs just in case)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Start the server
CMD php artisan serve --host=0.0.0.0 --port=$PORT