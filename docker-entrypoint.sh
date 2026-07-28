#!/bin/sh

# Go to the application root directory
cd /var/www/html

# Clear configuration cache first to prevent old env variables from being used
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations and seed data
php artisan migrate --force || echo "Migration skipped or failed"
php artisan db:seed --force || echo "Seeding skipped or failed"

# Re-create cache for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Link storage
php artisan storage:link || true

# Ensure proper permissions for www-data
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


