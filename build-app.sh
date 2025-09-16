#!/bin/bash

# Instalación
composer install --no-dev --no-interaction --prefer-dist

# Migraciones y seeders
php artisan migrate --force
php artisan db:seed --force

# Caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Cron en segundo plano
chmod +x ./run-cron.sh
./run-cron.sh &

# Inicia Laravel
php -S 0.0.0.0:8080 -t public
