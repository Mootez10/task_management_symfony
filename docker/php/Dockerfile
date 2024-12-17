# Base PHP-FPM image
FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev libonig-dev libxml2-dev unzip git curl \
    && docker-php-ext-install zip pdo_mysql opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy PHP configuration
COPY php.ini /usr/local/etc/php/php.ini

# Install Symfony CLI (optional, useful for dev)
#RUN curl -sS https://get.symfony.com/cli/installer | bash \
#    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Default command
CMD ["php-fpm"]