# Despliegue de Laravel en Railway

Este proyecto utiliza **Railway** para desplegar dos servicios desacoplados desde el mismo repositorio:

#  varibales para que railway solo ejecute el cron en el servicio cron y deje correr la app correectamente
- `web`: Servicio principal de Laravel (frontend + API)
- `cron`: Servicio dedicado a ejecutar los cronjobs vía scheduler

# railway para app
--en seccion *custom build command* colocar
 chmod +x ./build-app.sh && sh ./build-app.sh

-- en seccion *custom start command* colocar :
php artisan serve --host=0.0.0.0 --port=$PORT

# railway para servicio de cron

-- colocar la variable de entorno cron
-- en seccion *custom start command* colocar:
chmod +x ./run-cron.sh && sh ./run-cron.sh


