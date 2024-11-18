#!/bin/bash
set -e

# Verificar se o Composer está instalado e executar o "require"
if ! command -v composer &> /dev/null
then
    echo "Composer não encontrado. Instalando..."
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

# Instalar o Symfony Runtime (se necessário)
echo "Instalando symfony/runtime..."
composer require symfony/runtime

# Rodar as migrações (substitua por seu comando de migração)
if [ -f /var/www/html/bin/console ]; then
    echo "Rodando migrações do Symfony..."
    /var/www/html/bin/console doctrine:migrations:migrate --no-interaction
fi

# Iniciar o processo padrão (pode ser o php-fpm, MySQL ou outro serviço, dependendo da configuração do seu container)
exec "$@"
