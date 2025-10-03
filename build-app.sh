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

# Cronjob o servidor web según ROLE
if [ "$ROLE" = "cron" ]; then
  echo "[INIT] Iniciando cronjob..."
  chmod +x ./run-cron.sh
  ./run-cron.sh
else
  echo "[INIT] Iniciando servidor web Laravel..."
  php artisan serve --host=0.0.0.0 --port=8080
fi

