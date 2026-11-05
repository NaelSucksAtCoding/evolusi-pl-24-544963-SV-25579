#!/bin/sh
# Menyiapkan aplikasi saat container dijalankan, lalu menyalakan PHP-FPM dan Nginx.
set -e

# .env tidak ikut masuk image (.dockerignore), jadi dibuat dari contohnya.
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

# Basis data SQLite di dalam container: buat file, jalankan migrasi, isi data contoh.
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=ItemSeeder --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

# PHP-FPM jalan di latar belakang; Nginx (CMD) menjadi proses utama container.
php-fpm &

exec "$@"
