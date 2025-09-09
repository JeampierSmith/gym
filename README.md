# Gym

Aplicación web para la gestión de gimnasios desarrollada con PHP, MySQL y Docker.

## Requisitos

- Docker y Docker Compose
- Navegador web moderno

## Instalación

1. Clona el repositorio:
   ```sh
   git clone <URL-del-repositorio>
   cd gym
   ```

2. Instala las dependencias de PHP usando Composer:
   ```sh
   composer install
   ```
   o si usas Docker:
   ```sh
   docker-compose exec app composer install
   ```

3. Construye e inicia los servicios:
   ```sh
   docker-compose up -d --build
   ```

4. Accede a la aplicación:
   - Aplicación: [http://localhost:8080](http://localhost:8080)
   - phpMyAdmin: [http://localhost:8081](http://localhost:8081)

## Usuario de prueba

- **Usuario:** admin
- **Contraseña:** admin12345

## Servicios incluidos

- **app**: Servidor web Apache con PHP
- **db**: MySQL 5.7
- **phpmyadmin**: Interfaz web para administración de MySQL
- **selenium-hub** y **selenium-node-chrome**: Pruebas automatizadas (opcional)

## Variables de entorno

Configuradas en `docker-compose.yml`:
- `DB_HOST=db`
- `DB_USER=root`
- `DB_PASSWORD=root`
- `DB_NAME=gimnasios`

## Estructura del proyecto

- `Config/`: Configuración y utilidades
- `Controllers/`: Controladores de la aplicación
- `Models/`: Modelos de datos
- `Views/`: Vistas y plantillas
- `Assets/`: Recursos estáticos (CSS, JS, imágenes)
- `Libraries/`: Librerías externas
- `tests/`: Pruebas automáticas

## Inicialización de la base de datos

El archivo `gimnasios.sql` se carga automáticamente al iniciar el contenedor MySQL.

## Solución de problemas

Si la base de datos no inicia correctamente, elimina el volumen y reconstruye:
```sh
 docker-compose down
 docker volume rm gym_mysql_data
 docker-compose up -d --build
```

## Licencia

Este proyecto se distribuye bajo la licencia MIT.


