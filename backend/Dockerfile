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

# Instalar as dependências do PHP
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
