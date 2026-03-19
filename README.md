# Catálogo de Productos - Prueba Técnica

API REST desarrollada en Laravel para gestionar un catálogo de productos digitales.

---

## Tecnologías

- PHP (Laravel 10+)
- PostgreSQL
- JavaScript (Frontend básico)
- Axios (para llamadas a la API)
- Bootstrap (para estilos rápidos)

---

## Modelo de Datos

Producto:

| Campo       | Tipo      | Descripción                       |
|------------|-----------|-----------------------------------|
| id         | integer   | Identificador único               |
| nombre     | string    | Nombre del producto               |
| descripcion| string    | Descripción del producto          |
| precio     | decimal   | Precio del producto               |
| url        | string    | URL del recurso digital           |
| categoria  | string    | Categoría del producto            |
| estado     | boolean   | Activo (true) / Inactivo (false) |
| created_at | timestamp | Fecha de creación                 |
| updated_at | timestamp | Fecha de última actualización     |

---

## Backend

### Funcionalidades

- Listar productos activos
- Crear productos
- Actualizar productos
- Inhabilitar productos (no eliminación física)
- Validación de entradas
- Manejo de errores básico (404 si producto no existe)

### Endpoints

#### 1. Listar productos activos

- Método: `GET`
- URL: `/products`
- Respuesta:

```json
[
  {
    "id": 1,
    "nombre": "Curso Laravel",
    "descripcion": "Curso básico de Laravel 13",
    "precio": 49.99,
    "url": "http://example.com/curso-laravel.pdf",
    "categoria": "Educación",
    "estado": true,
    "created_at": "2026-03-19T01:15:48.000000Z",
    "updated_at": "2026-03-19T01:15:48.000000Z"
  }
]

. Crear producto

Método: POST

URL: /products

Body (JSON):

{
  "nombre": "Nuevo Producto",
  "descripcion": "Descripción del producto",
  "precio": 25.50,
  "url": "http://example.com/producto.pdf",
  "categoria": "Educación",
  "estado": true
}

Respuesta (201):

{
  "message": "Producto creado correctamente",
  "product": {
    "id": 3,
    "nombre": "Nuevo Producto",
    "descripcion": "Descripción del producto",
    "precio": 25.50,
    "url": "http://example.com/producto.pdf",
    "categoria": "Educación",
    "estado": true,
    "created_at": "2026-03-19T02:00:00.000000Z",
    "updated_at": "2026-03-19T02:00:00.000000Z"
  }
}
3. Actualizar producto

Método: PUT

URL: /products/{id}

Body (JSON, campos opcionales):

{
  "nombre": "Producto Actualizado",
  "precio": 30.00
}

Respuesta (200):

{
  "message": "Producto actualizado correctamente",
  "product": {
    "id": 3,
    "nombre": "Producto Actualizado",
    "descripcion": "Descripción del producto",
    "precio": 30.00,
    "url": "http://example.com/producto.pdf",
    "categoria": "Educación",
    "estado": true,
    "created_at": "2026-03-19T02:00:00.000000Z",
    "updated_at": "2026-03-19T02:05:00.000000Z"
  }
}
4. Inhabilitar producto

Método: DELETE

URL: /products/{id}

Respuesta (200):

{
  "message": "Producto inhabilitado correctamente"
}

Nota: Esto no elimina el producto físicamente, solo cambia estado a false. Ya no aparecerá en la lista de productos activos.



##  Instalación

1. Clonar repositorio
```bash
git clone https://github.com/BRAST89/catalogo-productos.git
cd backend

Frontend

Archivo principal: resources/views/index.blade.php

Carga automáticamente los productos desde la API Laravel.

Permite crear, editar y eliminar productos usando la misma tabla y formulario.

Necesita que el backend esté corriendo (php artisan serve).

Funcionalidades en la UI

Crear nuevo producto

Editar producto existente (llenando el formulario)

Inhabilitar producto (no elimina físicamente)

Visualizar todos los productos activos

Observaciones

Al editar un producto, el formulario reutiliza los campos y realiza un PUT a la API.

Al crear un producto, realiza un POST a la API.

El botón eliminar cambia estado a false y actualiza la lista.

Instalación
# Clonar repositorio
git clone https://github.com/BRAST89/catalogo-productos.git
cd backend

# Instalar dependencias
composer install

# Configurar .env y generar key
cp .env.example .env
php artisan key:generate

# Migrar base de datos
php artisan migrate

# Levantar el servidor
php artisan serve

La API estará disponible en http://127.0.0.1:8000/ (o el puerto que indique la terminal). http://127.0.0.1:8000/dashboard

Validaciones

nombre: obligatorio, máximo 255 caracteres

descripcion: obligatorio

precio: obligatorio, numérico

url: obligatorio, URL válida

categoria: obligatorio, máximo 100 caracteres

estado: obligatorio, booleano (true/false