FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libzip-dev \
    zip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project
COPY . .

# Install Laravel dependencies
RUN composer install

# Expose port
EXPOSE 10000

RUN docker-php-ext-install pdo pdo_mysql pdo pdo_pgsql

# Start server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000