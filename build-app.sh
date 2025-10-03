#!/bin/bash

# Instalación
composer install --no-dev --no-interaction --prefer-dist

# Migraciones y seeders
php artisan migrate --force
php artisan db:seed --force

echo "[BUILD] Migraciones y seeders..."
# Caches
php artisan config:cache
php artisan route:cache
php artisan view:cache



