FROM php:8.2-cli

# Instalar dependências
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-install xml intl pdo_mysql


RUN apt-get update && apt-get install -y \
    libxml2-dev \
    && docker-php-ext-install xml

# Copiar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar os arquivos do backend, incluindo composer.json
COPY . .

# Instalar dependências do PHP
RUN composer install --no-plugins --no-scripts

# Atualizar o Composer e as dependências
RUN composer self-update 2.1.0 && composer update -W

# Copiar o script de inicialização
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Tornar o script executável
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Configurar o entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Expor a porta e configurar o comando de entrada
EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
