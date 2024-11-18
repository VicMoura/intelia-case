FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    git \
    unzip \
    zip \
    wget \
    && docker-php-ext-install xml intl pdo_mysql

# Instalar o Symfony CLI (caso precise)
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Copiar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do backend (incluindo composer.json)
COPY . .

RUN composer install \
    --no-interaction \
    --no-scripts

# By default, Composer runs as root inside the container.
# This can lead to permission issues on your host filesystem.

RUN chown -R 1000:1000 vendor

RUN chmod -R 775 vendor

# Copiar o script de inicialização
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Tornar o script executável
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Configurar o entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]


ENV COMPOSER_ALLOW_SUPERUSER=1

# Expor a porta e configurar o comando de entrada
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]

