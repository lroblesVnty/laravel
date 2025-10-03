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

# Comportamiento según servicio
if [ "$ROLE" = "cron" ]; then
  echo "[INIT] Iniciando cronjob..."
  chmod +x ./run-cron.sh
  ./run-cron.sh
else
  echo "[INIT] Iniciando servidor web Laravel..."
  php -S 0.0.0.0:$PORT -t public
fi

