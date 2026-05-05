FROM php:8.2-alpine

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html/

# Copy the project files to the apache document root and set permissions
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/
