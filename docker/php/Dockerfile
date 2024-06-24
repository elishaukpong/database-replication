FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

USER root

RUN apt update && apt -f install -y \
        build-essential \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        locales \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        git \
        openssh-server \
        curl \
        libzip-dev \
        libfontconfig1 \
        libxrender1 \
        libpng-dev \
        make \
        nano \
        iputils-ping \
        ssh \
        sudo

# Install php extensions
RUN apt -f install -y libgmp-dev re2c libmhash-dev libmcrypt-dev file libtidy-dev \
    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ \
    && docker-php-ext-configure gmp \
    && docker-php-ext-install gmp \
    && docker-php-ext-install pdo_mysql zip exif pcntl bcmath \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install tidy \
    && docker-php-ext-configure tidy \
    && docker-php-ext-enable tidy

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Verify installation
RUN composer --version

# sudo www-data
RUN echo "www-data ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

USER www-data
