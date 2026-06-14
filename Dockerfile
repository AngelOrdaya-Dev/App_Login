FROM serversideup/php:8.2-fpm-nginx

# Set Laravel environment
ENV SSL_MODE="off"
ENV AUTORUN_ENABLED=true
ENV PHP_OPCACHE_ENABLE=1

# Install Node.js for Vite build
USER root
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy application files
WORKDIR /var/www/html
COPY --chown=www-data:www-data . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm install && npm run build && rm -rf node_modules

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cache Laravel config
RUN php artisan config:clear \
    && php artisan route:cache \
    && php artisan view:cache

USER www-data
