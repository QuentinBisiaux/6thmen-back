FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    software-properties-common \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd intl pdo pdo_pgsql zip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Create a non-root user with the same UID and GID as the host
ARG UID
ARG GID
ARG USER_NAME

# Use build arguments to create a group and user inside the container
RUN groupadd -g ${GID} ${USER_NAME} && \
    useradd -m -u ${UID} -g ${GID} -s /bin/bash ${USER_NAME}

# Switch to the new user
USER ${USER_NAME}

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

