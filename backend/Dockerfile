# Dockerfile do backend PHP/Symfony
FROM php:8.2-cli

# Instalar dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    git \
    unzip \
    zip \
    php8.2-xml \  # Instalar a extensão xml
    && docker-php-ext-install intl pdo_mysql xml \  # Habilitar a extensão xml
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar os arquivos do backend, incluindo composer.json
COPY . .

# Instalar dependências do PHP
RUN composer self-update 2.1.0

# Copiar o script de inicialização
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Tornar o script executável
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Configurar o entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Expor a porta e configurar o comando de entrada
EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
