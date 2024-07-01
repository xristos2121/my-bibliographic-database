#!/bin/sh

# Wait for the database to be ready
while ! nc -z db 3306; do
  echo "Waiting for database connection..."
  sleep 1
done

# Check if the database exists, and create it if it doesn't
echo "Checking if the database exists..."
if ! php -r "exit((new mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')))->select_db(getenv('DB_DATABASE')) ? 0 : 1);" ; then
  echo "Database does not exist. Creating database..."
  php -r "exit((new mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')))->query('CREATE DATABASE ' . getenv('DB_DATABASE')) ? 0 : 1);"
else
  echo "Database exists."
fi

# Ensure the memory limit is set
if [ -n "$PHP_MEMORY_LIMIT" ]; then
    echo "memory_limit = $PHP_MEMORY_LIMIT" > /usr/local/etc/php/conf.d/memory-limit.ini
fi

# Run the command passed as arguments
exec "$@"

# Run database migrations
echo "Running migrations..."
php artisan queue:table
php artisan migrate --force

# Start Supervisor to manage PHP-FPM and Laravel Queue Worker
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
