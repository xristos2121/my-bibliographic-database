# Use the official PHP image with FPM
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/laravel laravel
RUN mkdir -p /home/laravel/.composer && \
    chown -R laravel:laravel /home/laravel

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Create vendor directory and set permissions
RUN mkdir -p /var/www/vendor && \
    chown -R laravel:www-data /var/www && \
    chmod -R 775 /var/www

# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# Switch to laravel user
USER laravel

# Install dependencies
RUN composer install --no-interaction --no-plugins --no-scripts

# Switch back to root for entrypoint execution
USER root

# Expose port 9000 and start php-fpm server
EXPOSE 9000
ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]
