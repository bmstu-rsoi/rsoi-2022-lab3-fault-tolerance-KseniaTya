FROM php:8.1-apache
WORKDIR /var/www/html
RUN a2enmod rewrite
RUN apt-get install -y && apt-get install -y curl
RUN apt-get -y update
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql