# Usa a imagem oficial php com fpm e extensões para Laravel
FROM php:8.2-fpm

# Instala dependências necessárias do sistema
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura diretório da aplicação
WORKDIR /var/www/html

# Copia os arquivos da aplicação
COPY . .

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Permissões básicas (storage e cache)
RUN chown -R www-data:www-data storage bootstrap/cache

# Copia configuração do nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

# Expõe a porta 8080 para o Railway
EXPOSE 8080

# Comando para rodar PHP-FPM e nginx
CMD service nginx start && php-fpm
