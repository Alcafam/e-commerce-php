# Use official PHP + Apache image
FROM php:7.4-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install extensions if needed (e.g., mysqli, pdo)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory inside container
WORKDIR /var/www/html

# Copy project files into container
COPY . /var/www/html

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Optional: set up Apache config for CodeIgniter's clean URLs
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html|' /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80