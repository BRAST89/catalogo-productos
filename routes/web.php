<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return 'API de productos funcionando';
});

// CRUD productos
Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);

// Ruta para la interfaz frontend
Route::get('/dashboard', function () {
    return view('index'); // resources/views/index.blade.php
});