# Use the official Composer image to install Composer
FROM composer:latest AS composer

# Use the official PHP image as the base image for your application
FROM php:8.1-fpm

# Install dependencies for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    netcat-openbsd \
    default-mysql-client \
    supervisor \
    libicu-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd intl

# Set working directory
WORKDIR /var/www

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer from the Composer image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Add user for Laravel application
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Create necessary directory structure and set permissions
RUN mkdir -p /var/www/vendor && chown -R www:www /var/www

# Change ownership of the working directory to the www user
COPY --chown=www:www . /var/www

# Copy Supervisor configuration file
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy entrypoint script before changing user to www
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Make scripts executable before changing user to www
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy PHP custom configuration
COPY php/local.ini /usr/local/etc/php/conf.d/local.ini

# Change current user to www
USER www

WORKDIR /var/www

# Create cache directory and set appropriate permissions
# Ensure cache and views directories exist and set appropriate permissions
RUN mkdir -p /var/www/storage/framework/views && \
    mkdir -p /var/www/bootstrap/cache && \
    chown -R www:www /var/www/storage/framework/views && \
    chown -R www:www /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage/framework/views && \
    chmod -R 775 /var/www/bootstrap/cache


# Install Composer dependencies
RUN composer install && ls -al /var/www/vendor

# Expose port 9000
EXPOSE 9000

# Use the entrypoint script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
