#!/usr/bin/env bash
# Skrip deploy ke server production. Dijalankan dari root proyek di server.
# set -e: hentikan skrip begitu ada satu perintah yang gagal.
set -e

echo "Starting deployment..."

echo "1. Turn on maintenance mode"
php artisan down || true

echo "2. Pull latest code from main branch"
git pull origin main

echo "3. Install dependencies"
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

echo "4. Clear and cache routes, config, and views"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "5. Run database migrations"
php artisan migrate --force

echo "6. Install and build front-end assets"
npm ci
npm run build

echo "7. Turn off maintenance mode"
php artisan up

echo "Deployment finished successfully!"
