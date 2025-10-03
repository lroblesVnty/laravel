#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x run-cron.sh`

# This block of code runs the Laravel scheduler every minute
while true
do
  echo "[CRON] Ejecutando scheduler: $(date)" | tee -a storage/logs/cron.log
  php artisan schedule:run --verbose --no-interaction 2>&1 | tee -a storage/logs/cron.log
  sleep 60
done
