<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Listar productos activos
    public function index()
    {
        $products = Product::where('estado', true)->get();
        return response()->json($products, 200);
    }

    
    // Crear un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'url' => 'required|url',
            'categoria' => 'required|string|max:100',
            'estado' => 'required|boolean'
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'message' => 'Producto creado correctamente',
            'product' => $product
        ], 201);
    }

    // Actualizar producto existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric',
            'url' => 'sometimes|required|url',
            'categoria' => 'sometimes|required|string|max:100',
            'estado' => 'sometimes|required|boolean'
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'product' => $product
        ], 200);
    }

    // Inhabilitar o eliminar producto
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->estado = false;
        $product->save();

        return response()->json([
            'message' => 'Producto inhabilitado correctamente'
        ], 200);
    }
}