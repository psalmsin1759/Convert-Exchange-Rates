# FROM php:8.2-fpm
FROM php:8.2


RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    librdkafka-dev \
    && docker-php-ext-install pdo pdo_mysql sockets \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install gd \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get install autoconf && pecl install -o -f redis \
&& rm -rf /tmp/pear \
&& docker-php-ext-enable redis   

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN alias composer='php composer.phar'

COPY composer.json composer.lock ./

COPY .env.example .env

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-progress --prefer-dist

RUN composer dump-autoload --optimize

# Install Cloud SQL Proxy - GCP
COPY --from=gcr.io/cloudsql-docker/gce-proxy:1.19.1 /cloud_sql_proxy /cloud_sql_proxy

COPY entrypoint.sh /usr/local/bin/

RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 8080


ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
