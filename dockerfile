# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Activamos el módulo de reescritura de Apache (útil para la carpeta public)
RUN a2enmod rewrite

# Instalamos extensiones del sistema necesarias para Composer y PHP
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Descargamos e instalamos Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuramos el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiamos los archivos del proyecto al contenedor
COPY . .

# Instalamos las dependencias de Composer optimizadas para producción
RUN composer install --no-dev --optimize-autoloader

# Cambiamos los permisos de Apache para que pueda leer los archivos correctamente
RUN chown -R www-data:www-data /var/www/html

# Configuramos Apache para que su raíz apunte a tu carpeta /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Exponemos el puerto 80
EXPOSE 80