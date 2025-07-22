# Use PHP Apache base
FROM php:8.2-apache

# Update & install required packages
RUN apt-get update && \
    apt-get install -y ca-certificates curl && \
    docker-php-ext-install sockets

# Enable allow_url_fopen (required for file_get_contents over HTTPS)
RUN echo "allow_url_fopen=On" > /usr/local/etc/php/conf.d/allow_url_fopen.ini

# Enable Apache mod_rewrite (optional but good for Laravel, WordPress, etc.)
RUN a2enmod rewrite

# Copy project files to Apache root
COPY . /var/www/html/

# Set proper permissions (optional but helpful)
RUN chown -R www-data:www-data /var/www/html

# Expose HTTP port
EXPOSE 80
