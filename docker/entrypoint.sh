#!/usr/bin/env bash
# Menyiapkan aplikasi saat container pertama kali dijalankan, lalu menjalankan Apache.
set -e

# .env tidak ikut masuk image (.dockerignore), jadi dibuat dari contohnya.
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

# Basis data SQLite di dalam container: buat file, jalankan migrasi, isi data contoh.
touch database/database.sqlite
chown www-data:www-data database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=ItemSeeder --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
