# Use PHP Apache image
FROM php:8.2-apache

# Copy all project files to container's web root
COPY . /var/www/html/

# Enable Apache rewrite module (optional for .htaccess)
RUN a2enmod rewrite

# Expose default Apache port
EXPOSE 80
