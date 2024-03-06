# Use the official PHP and Apache base image
FROM php:apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy the custom php.ini file
COPY php.ini /usr/local/etc/php/

# Make sure to include the PHP module for handling .htaccess files
RUN a2enmod rewrite