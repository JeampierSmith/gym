# Usa la imagen oficial de PHP como imagen base
FROM php:8.0-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql mysqli zip gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el contenido del directorio actual al contenedor en /var/www/html
COPY . /var/www/html


# Instalar dependencias
RUN composer install --no-interaction --no-plugins --no-scripts
RUN composer require firebase/php-jwt

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80 al mundo exterior
EXPOSE 80

# Ejecuta Apache en primer plano
CMD ["apache2-foreground"]