#!/bin/sh
set -e

# Create Laravel directories if they don't exist
mkdir -p /var/www/storage/app /var/www/storage/framework/cache /var/www/storage/framework/sessions /var/www/storage/framework/views /var/www/storage/logs /var/www/bootstrap/cache

# Fix storage permissions
chown -R laravel:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Ensure .env file exists and is writable
if [ ! -f /var/www/.env ]; then
    cp /var/www/.env.example /var/www/.env
    chown laravel:www-data /var/www/.env
    chmod 664 /var/www/.env
fi

# Run composer install as laravel user
su -c "composer install --no-interaction --no-plugins --no-scripts" -s /bin/sh laravel

# Generate application key if not set
if [ -z "$(grep '^APP_KEY=' /var/www/.env)" ] || [ "$(grep '^APP_KEY=' /var/www/.env)" = 'APP_KEY=' ]; then
    su -c "php artisan key:generate" -s /bin/sh laravel
fi

# Cache configuration
su -c "php artisan config:cache" -s /bin/sh laravel

# Run database migrations
if [ ! "$(php artisan migrate:status | grep 'Yes')" ]; then
    su -c "php artisan migrate --force" -s /bin/sh laravel
fi

# Start PHP-FPM
exec "$@"
