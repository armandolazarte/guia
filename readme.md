# Gestor Universitario de Información y Administración (GUIA)

## Requerimientos

- Git
- Composer
- PHP
- MySQL / MariaDB

## Instalación

1. Clonar proyecto
2. Instalar dependencias del proyecto: composer install
3. Crear archivo .env
4. Base de datos
    1. Crear base de datos
    2. Instalar sistema de migraciones: php artisan migrate:install
    3. Crear tablas: php artisan migrate
    4. Ejecutar semillas: php artisan db:seed

## Configuración

1. Modificar contraseña de usuario root
2. Importar infromación de base de datos

### Licencia

[MIT license](http://opensource.org/licenses/MIT)
