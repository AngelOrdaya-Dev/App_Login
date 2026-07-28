#!/bin/sh

# Go to the application root directory
cd /var/www/html

# Clear configuration cache first to prevent old env variables from being used
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run migrations and seed data
php artisan migrate --force || echo "Migration skipped or failed"
php artisan db:seed --force || echo "Seeding skipped or failed"

# Re-create cache for production performance
php artisan config:cache || echo "Config cache skipped"
php artisan view:cache || echo "View cache skipped"

# Link storage
php artisan storage:link || true

# Ensure proper permissions for www-data
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

exit 0


