# Image Laravel multi-stage, basis data SQLite di dalam container.
# Tahap "builder" memasang dependensi dengan Composer; tahap akhir hanya membawa
# PHP-FPM, Nginx, dan hasil build — Composer tidak ikut ke image akhir.

# ---------- Tahap 1 · builder ----------
FROM php:8.3.36-fpm-alpine3.24 AS builder

COPY --from=composer:2.9.8 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dependensi PHP dipasang SEBELUM kode aplikasi disalin.
# Layer ini hanya dibangun ulang bila composer.json/composer.lock berubah.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && chmod +x docker/entrypoint.sh

# ---------- Tahap 2 · runtime ----------
FROM php:8.3.36-fpm-alpine3.24

LABEL org.opencontainers.image.source="https://github.com/NaelSucksAtCoding/evolusi-pl-24-544963-SV-25579"

# Nginx sebagai web server. Versinya dikunci ke 1.30.x dari repo Alpine 3.24.
RUN apk add --no-cache nginx~1.30 \
    && chown -R www-data:www-data /var/lib/nginx /var/log/nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www/html

# Hanya hasil build yang diambil dari tahap builder. Kode tetap milik root (hanya-baca bagi
# aplikasi); www-data cukup boleh menulis ke folder yang memang perlu ditulisi.
COPY --from=builder /app .
RUN chown www-data:www-data . \
    && chown -R www-data:www-data storage bootstrap/cache database

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

EXPOSE 8080

# Container tidak berjalan sebagai root.
USER www-data

# Docker menandai container (healthy) selama route /up milik Laravel menjawab.
HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --start-interval=2s --retries=3 \
    CMD wget -q -O /dev/null http://127.0.0.1:8080/up || exit 1

ENTRYPOINT ["docker/entrypoint.sh"]
CMD ["nginx", "-g", "daemon off;"]
