# Use official PHP 7.4 + Apache image
FROM php:7.4-apache

# Enable mod_rewrite (needed for CodeIgniter clean URLs)
RUN a2enmod rewrite

# Install PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy the entire CodeIgniter app into the container
COPY . /var/www/html

# Fix permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (Apache default)
EXPOSE 80