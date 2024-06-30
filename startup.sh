#!/bin/bash

# Start the PHP-FPM service
php-fpm &

# Start the queue worker
php /var/www/artisan queue:work --sleep=3 --tries=3 &

# Wait for all background processes to finish
wait
