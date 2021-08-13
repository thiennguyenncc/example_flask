FROM php:8.0.6-fpm
ENV PHP_EXTRA_CONFIGURE_ARGS \
  --enable-fpm \
  --with-fpm-user=www-data \
  --with-fpm-group=www-data \
  --enable-intl \
  --enable-opcache \
  --enable-zip \
  --enable-calendar

# Install some must-haves
RUN apt-get update && \
    apt-get install -y \
    vim \
    wget \
    sendmail \
    git \
    zlib1g-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libcurl4-openssl-dev \
    libldap2-dev

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    cron 

RUN docker-php-ext-configure \
      gd --with-freetype --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    curl \
    intl \
    opcache \
    pdo \
    soap \
    xml \
    zip

#RUN apt-get install php-imap php-mcrypt php-pecl-imagick php-pspell php-tidy

# install xdebug
# RUN pecl install xdebug

# Prepare PHP environment
COPY ./infra/php/fpm-pool.conf /etc/php-fpm.conf
COPY ./infra/php/php-fpm.d/zzz-www.conf /etc/php-fpm.d/www.conf
COPY ./infra/php/php.ini /usr/local/etc/php/php.ini
# COPY config/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install Nginx
# RUN apt-get update \
RUN  apt-get install -y software-properties-common \
    # && apt-add-repository -y ppa:nginx/stable \
    && apt install gnupg2 -y\
    && apt-get update \
    && apt-get install -y nginx \
    && rm -rf /var/lib/apt/lists/*
# Config
COPY ./infra/nginx/nginx.conf /etc/nginx/nginx.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer

RUN rm /etc/nginx/sites-enabled/default
RUN rm /etc/nginx/sites-available/default

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# COPY SOURCE
RUN mkdir /var/www/xvolve
COPY . /var/www/xvolve 
WORKDIR /var/www/xvolve
# RUN rm -rf .env 
RUN mv .env.docker .env
COPY ./cron/cronjob /etc/cron.d/container_cronjob
RUN chmod 0644 /etc/cron.d/container_cronjob
RUN crontab /etc/cron.d/container_cronjob
RUN touch /var/log/cron.log
# RUN composer install
# RUN chown -R www-data:www-data /var/www/xvolve

# RUN service nginx start
# Expose ports

EXPOSE 80
CMD composer install && chown -R www-data:www-data /var/www/xvolve && nginx && php-fpm -F -R && cron && tail -f /var/log/cron.log


