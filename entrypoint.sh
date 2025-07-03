#!/bin/sh

# Executa migrations, se quiser (opcional):
# php artisan migrate --force

# Inicia o PHP-FPM e o nginx
php-fpm &
nginx -g 'daemon off;
