FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libsqlite3-dev \
    libzip-dev \
    unzip \
    git \ 
    && docker-php-ext-install zip pdo_mysql soap pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configuração do Xdebug para cobertura de código
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .
