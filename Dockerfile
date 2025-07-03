# Usa a imagem oficial PHP com FPM (recomendada para Laravel)
FROM php:8.2-fpm

# Instala dependências do sistema
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

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos da aplicação para dentro do container
COPY . .

# Instala as dependências PHP em modo produção
RUN composer install --no-dev --optimize-autoloader

# Ajusta permissões básicas
RUN chown -R www-data:www-data storage bootstrap/cache

# Copia configuração customizada do nginx para dentro do container
COPY ./nginx.conf /etc/nginx/sites-available/default

# Cria link simbólico do nginx.conf (boa prática)
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Copia script de entrada (entrypoint)
COPY entrypoint.sh /entrypoint.sh

# Dá permissão de execução ao entrypoint
RUN chmod +x /entrypoint.sh

# Expõe a porta 8080 (usada pelo Railway)
EXPOSE 8080

# Usa o entrypoint como comando padrão
CMD ["/entrypoint.sh"]
