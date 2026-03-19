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
        Product::factory()->create(['estado' => true]);  // Activo
        Product::factory()->create(['estado' => false]); // Inactivo

        // Hacemos la petición GET al endpoint /products
        $response = $this->get('/products');

        // Verificamos que la respuesta sea 200 OK
        $response->assertStatus(200);

        // Verificamos que solo devuelva 1 producto (activo)
        $response->assertJsonCount(1);
    }
}