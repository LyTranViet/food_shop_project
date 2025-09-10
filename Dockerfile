FROM php:8.2-apache

# Cài extension PHP cho MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli


# Phân quyền cho Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Mở cổng 80
EXPOSE 80
