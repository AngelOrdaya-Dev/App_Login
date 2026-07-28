FROM serversideup/php:8.2-fpm-nginx

# Set Laravel environment
ENV SSL_MODE="off"
ENV AUTORUN_ENABLED=true
ENV PHP_OPCACHE_ENABLE=1
ENV HTTP_PORT=8080

# Install Node.js for Vite build and PostgreSQL extensions for PHP
USER root
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs \
    && install-php-extensions pgsql pdo_pgsql \
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

# Copy startup script using standard COPY + RUN chmod for maximum Docker compatibility
COPY docker-entrypoint.sh /etc/entrypoint.d/99-docker-entrypoint.sh
RUN chmod +x /etc/entrypoint.d/99-docker-entrypoint.sh

EXPOSE 8080

