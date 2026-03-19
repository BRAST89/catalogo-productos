# Usamos PHP con FPM
FROM php:8.2-fpm

# Instalar extensiones necesarias y utilidades
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Exponer puerto de PHP-FPM
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]