# Image Laravel: PHP 8.3 + Apache, basis data SQLite di dalam container.
FROM php:8.3-apache

# 1 · Paket sistem — paling jarang berubah, jadi ditaruh paling atas.
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*

# 2 · Apache melayani folder public/ dan mengizinkan .htaccess Laravel.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && printf 'ServerName localhost\n<Directory ${APACHE_DOCUMENT_ROOT}>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
        > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel \
    && a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3 · Dependensi PHP dipasang SEBELUM kode aplikasi disalin.
#     Layer ini hanya dibangun ulang bila composer.json/composer.lock berubah.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

# 4 · Baru kode aplikasi. Mengubah satu huruf di kode hanya membangun ulang dari sini.
COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod +x docker/entrypoint.sh

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

EXPOSE 80

ENTRYPOINT ["docker/entrypoint.sh"]
CMD ["apache2-foreground"]
