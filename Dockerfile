# Use an official PHP image with Apache
FROM php:8.1-apache

# Install PHP extensions (MySQL support)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module (if needed)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy your entire project into the container
COPY . /var/www/html/

# Set file permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Expose default port 80
EXPOSE 80
