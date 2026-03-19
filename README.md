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

estado: obligatorio, booleano (true/false)

---

## Escalabilidad y Consideraciones para 1 Millón de Usuarios Diarios

Para que el servicio soporte alta concurrencia (1 millón de usuarios diarios), se podrían implementar los siguientes cambios:

- **Base de datos**: migrar a un clúster o utilizar réplicas para balanceo de lectura/escritura y mejorar disponibilidad.
- **Caching**: usar Redis o Memcached para consultas frecuentes, por ejemplo, la lista de productos activos.
- **API**: implementar paginación, filtrado y limitar los campos devueltos para reducir carga de la red y tiempo de respuesta.
- **Servidor**: balanceo de carga con múltiples instancias del backend, por ejemplo usando Nginx o HAProxy.
- **Colas/Jobs**: operaciones pesadas o asincrónicas (notificaciones, reportes) se procesan en colas para no bloquear la API.
- **Docker/Kubernetes**: contenerización para despliegues consistentes y escalado automático.
- **Optimización de queries**: índices en campos frecuentemente filtrados (como `estado`) y consultas optimizadas.

---


Pruebas Automatizadas

Se incluye una prueba mínima para verificar que el endpoint GET /products funciona correctamente y devuelve únicamente los productos activos.

Archivo de prueba

tests/Feature/ProductTest.php

Código de la prueba
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /** @test */
    public function it_can_list_active_products()
    {
        // Creamos productos de prueba
        Product::factory()->create(['estado' => true]); 
        Product::factory()->create(['estado' => false]); 

        // Hacemos la petición GET al endpoint /products
        $response = $this->get('/products');

        // Verificamos que la respuesta sea 200 OK
        $response->assertStatus(200);

        // Verificamos que solo se devuelva 1 producto (activo)
        $response->assertJsonCount(1);
    }
}
Qué verifica la prueba

Inserta dos productos de prueba:

Uno activo (estado = true)

Uno inactivo (estado = false)

Realiza una petición GET /products.

Verifica que la respuesta:

Devuelva código HTTP 200.

Contenga únicamente el producto activo (assertJsonCount(1)).

Esta prueba asegura que el endpoint cumple correctamente su función de listar solo productos activos.

Cómo ejecutar la prueba

Desde la raíz del proyecto Laravel:

php artisan test

Laravel ejecutará la prueba y mostrará los resultados.

Una salida exitosa será similar a:

1 tests, 1 assertions, 0 failures