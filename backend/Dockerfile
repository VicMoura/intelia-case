# Usar imagem base do PHP 8.2 CLI
FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-install intl pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do backend, incluindo composer.json e composer.lock
COPY . .

# Instalar dependências do projeto e o Symfony Runtime
RUN composer install --no-scripts --no-progress && \
    composer require symfony/runtime

# Atualizar o Composer para uma versão estável específica (opcional)
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
