# Use the official PHP 8.3 Apache image as the base image
FROM php:8.3-apache

# Set non-interactive mode for apt-get
ENV DEBIAN_FRONTEND=noninteractive

# Update package list and install prerequisites
RUN apt-get update && apt-get install -y \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg

# Update certificates
RUN update-ca-certificates

# Install necessary packages
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    git \
    unzip \
    vim \
    default-mysql-client \
    default-libmysqlclient-dev

# Clean up APT when done
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Download and install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Set DocumentRoot to the public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/|/var/www/html/public|g' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy the Symfony project files to the container
COPY . /var/www/html

# Set the appropriate permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]