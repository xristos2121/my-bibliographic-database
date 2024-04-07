FROM php:8.1-fpm

# Install dependencies for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /var/www

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add user for Laravel application
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Change ownership of the working directory to the www user
# This is done before running composer to ensure that the composer cache and vendor directories
# are owned by the www user
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Install Composer dependencies including smalot/pdfparser
RUN composer require smalot/pdfparser

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
