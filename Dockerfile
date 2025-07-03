# Usa a imagem oficial PHP com FPM e extensões para Laravel
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

# Instala dependências PHP (produção)
RUN composer install --no-dev --optimize-autoloader

# Ajusta permissões básicas (storage e cache)
RUN chown -R www-data:www-data storage bootstrap/cache

# Copia configuração do nginx (supondo que você tenha nginx.conf no projeto)
COPY ./nginx.conf /etc/nginx/sites-available/default

# Copia o script entrypoint para o container
COPY entrypoint.sh /entrypoint.sh

# Dá permissão de execução para o entrypoint
RUN chmod +x /entrypoint.sh

# Expõe a porta 8080 para o Railway
EXPOSE 8080

# Usa o entrypoint.sh para rodar os serviços
CMD ["/entrypoint.sh"]
