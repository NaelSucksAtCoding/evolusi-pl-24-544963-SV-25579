#!/usr/bin/env bash
# Skrip deploy ke server production.
# set -e: hentikan skrip begitu ada satu perintah yang gagal, supaya
# aplikasi tidak dibuka kembali (artisan up) dalam keadaan rusak.
set -e

cd /var/www/aplikasi

echo "Starting deployment..."

echo "1. Kunci pintu: tampilkan halaman pemeliharaan"
php artisan down --retry=60

echo "2. Ambil kode terbaru"
git pull origin main

echo "3. Pasang dependensi (tanpa paket dev)"
composer install --no-dev --optimize-autoloader

echo "4. Ubah skema basis data"
php artisan migrate --force

echo "5. Bangun ulang cache dengan kode & config baru"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "6. Muat ulang pekerja antrean"
php artisan queue:restart

echo "7. Buka pintu kembali"
php artisan up

echo "Deployment finished successfully!"
