FROM php:7.3-apache

RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

RUN apt-get install -y libicu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite
RUN sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf
RUN mv /var/www/html /var/www/public
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer self-update --1

WORKDIR /var/www
