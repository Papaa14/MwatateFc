FROM php:8.2-fpm-alpine

# Build arguments for user ID and group ID
ARG USER_ID=1000
ARG GROUP_ID=1000

# Install system dependencies
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    mysql-client \
    shadow \
    sudo

# Install PHP extensions needed for Laravel
RUN docker-php-ext-install pdo pdo_mysql gd xml zip

# Install Composer (PHP package manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a non-root user with matching UID/GID
RUN groupadd -g ${GROUP_ID} appgroup || true \
    && useradd -u ${USER_ID} -g ${GROUP_ID} -m -s /bin/sh appuser || true

# Set working directory and permissions
WORKDIR /var/www/html

# Create necessary directories with proper permissions
RUN mkdir -p /var/www/html/storage/app/public \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && mkdir -p /home/appuser/.composer

# Set proper ownership
RUN chown -R appuser:appgroup /var/www/html \
    && chown -R appuser:appgroup /home/appuser

# Configure PHP-FPM to run as our user
RUN sed -i 's/user = www-data/user = appuser/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/group = www-data/group = appgroup/g' /usr/local/etc/php-fpm.d/www.conf

# Switch to non-root user
USER appuser

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]