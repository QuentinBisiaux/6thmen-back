FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    vim \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

## Install PHP extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions amqp apcu bcmath exif gd grpc imap intl ldap mcrypt opcache pgsql pdo_pgsql sockets uuid xdebug yaml zip

# Get latest Composer
COPY --from=composer:2.4.2 /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/rayuruna rayuruna
RUN mkdir -p /home/rayuruna/.composer && \
    chown -R rayuruna:rayuruna /home/rayuruna

# Set working directory
WORKDIR /var/www

USER rayuruna
