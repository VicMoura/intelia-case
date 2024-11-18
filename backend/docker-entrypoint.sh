#!/bin/bash
set -e

# Rodar as migrações
php bin/console doctrine:migrations:migrate --no-interaction

# Rodar o servidor PHP ou o comando desejado
exec "$@"
