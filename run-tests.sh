#!/bin/bash

# Colores para la salida
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo "Ejecutando pruebas unitarias..."
echo "--------------------------------"

# Ejecutar las pruebas
docker-compose exec app vendor/bin/phpunit

# Verificar el resultado
if [ $? -eq 0 ]; then
    echo -e "${GREEN}Todas las pruebas pasaron exitosamente${NC}"
else
    echo -e "${RED}Algunas pruebas fallaron${NC}"
fi 