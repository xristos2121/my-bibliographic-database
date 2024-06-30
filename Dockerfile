# Use the official Composer image to install Composer
FROM composer:latest as composer

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
    supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

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

# Change current user to www
USER www

# Install Composer dependencies
RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs

# Expose port 9000
EXPOSE 9000

# Use the entrypoint script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
