#!/bin/sh

# Inicia nginx em background
nginx -g "daemon off;" &

# Inicia php-fpm em foreground (mantém o container vivo)
php-fpm -F
