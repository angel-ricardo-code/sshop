<?php
use App\Http\Controllers\venta_controller;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



//Esta ruta actúa como API para Js, el autocompletado
Route::get('/product-data/{id}', function ($id) {

    if (!ctype_digit($id)) {
        return response()->json(['error' => 'El id es invalido'], 400);
    }

    $producto = Producto::findOrFail($id);

    return response()->json([
        'producto' => $producto->nombre,
        'precio_venta' => $producto->precio_venta,
        'stock' => $producto->stock(),
    ]);

})->middleware(['throttle:60,1']);

