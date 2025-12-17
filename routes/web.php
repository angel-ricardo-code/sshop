<?php

use App\Http\Controllers\inventario_controller;
use App\Http\Controllers\register_controller;
use App\Http\Controllers\statsController;
use App\Http\Controllers\venta_controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/inicio', [\App\Http\Controllers\home_controller::class, 'index'])->name('inicio')->middleware(\App\Http\Middleware\gustomMiddleware::class);

//->middleware(\App\Http\Middleware\gustomMiddleware::class);

Route::post('/quick', [\App\Http\Controllers\home_controller::class, 'quickAccess'])->name('quickAccess');


Route::view('/bienvenido', 'bienvenido')->name('bienvenido');

Route::view('/compra', 'compras.index')->middleware(\App\Http\Middleware\gustomMiddleware::class);

Route::view('/error', 'error')->name('error');


//Estadísticas
Route::get('/estadisticas', [statsController::class, 'index'])->name('estadisticas')->middleware(\App\Http\Middleware\gustomMiddleware::class);
Route::get('/estadisticas/{stat}', [statsController::class, 'show_all'])->name('show_all')->middleware(\App\Http\Middleware\gustomMiddleware::class);
Route::post('/goBack', [statsController::class, 'goBack'])->name('goBack')->middleware(\App\Http\Middleware\gustomMiddleware::class);
//Compras
Route::get('/agregar-productos', [\App\Http\Controllers\producto_controller::class, 'create'])->middleware(\App\Http\Middleware\gustomMiddleware::class);
Route::post('/agregar-productos', [\App\Http\Controllers\producto_controller::class, 'store'])->middleware(\App\Http\Middleware\gustomMiddleware::class);

//Manejar inventario
Route::get('/inventario', [\App\Http\Controllers\inventario_controller::class, 'index'])->name('inventario')->middleware(\App\Http\Middleware\gustomMiddleware::class);
Route::post('/inventario', [inventario_controller::class, 'manage'])->middleware(\App\Http\Middleware\gustomMiddleware::class);

Route::get('/editar-productos', [\App\Http\Controllers\producto_controller::class, 'edit'])
            ->middleware(\App\Http\Middleware\gustomMiddleware::class)
            ->name('producto.editar');
Route::post('/editar-productos', [inventario_controller::class, 'update'])->name('producto.update')->middleware(\App\Http\Middleware\gustomMiddleware::class);


//Ventas
Route::get('/venta', [venta_controller::class, 'create'])->name('venta.create')->middleware(\App\Http\Middleware\gustomMiddleware::class);
Route::post('/venta', [venta_controller::class, 'store'])->name('venta.store')->middleware(\App\Http\Middleware\gustomMiddleware::class);


Route::get('/venta-confirmacion', [venta_controller::class, 'confirmacion'])->name('venta.confirmacion')->middleware(\App\Http\Middleware\gustomMiddleware::class);
Route::post('/venta-confirmacion', [venta_controller::class, 'confirmar'])->name('ventas.confirmar');


//Confirmaciones
Route::get('/eliminar-producto', function () {

    $ids = session()->get('ids');


    if (!$ids)
        return redirect()->route('inventario')->with('ids', $ids);


    return view('confirmaciones.eliminar-producto', compact('ids'));

})->name('eliminar.confirmacion')->middleware(\App\Http\Middleware\gustomMiddleware::class);
Route::post('/eliminar-producto', [inventario_controller::class, 'eliminar'])->name('eliminar.confirmacion')->middleware(\App\Http\Middleware\gustomMiddleware::class);


//Registration
Route::get('/login', [\App\Http\Controllers\register_controller::class, 'index'])->name('view-login');
Route::get('/register', [\App\Http\Controllers\register_controller::class, 'create'])->name('register');

Route::post('/nuevo-usuario', [\App\Http\Controllers\register_controller::class, 'store'])->name('nuevo-usuario');
Route::post('/login', [register_controller::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\register_controller::class, 'logout'])->name('logout');


Route::get('/stats', function (\Illuminate\Http\Request $request) {


    try {

        $user = request()->user()->id;


        $productos = DB::select("
         WITH inv AS (SELECT id_producto, stock FROM user_inventario(1)),
            categorias AS (SELECT i.id_producto, p.categoria, i.stock FROM producto p, inv i WHERE p.id_usuario = 1 AND i.id_producto = p.id)
        SELECT c.categoria, ROUND(SUM(c.stock)*1.0/(SELECT sum(i.stock) FROM inv i),2)*100 AS percent FROM categorias c GROUP BY c.categoria;
    ");

        return response()->json([
            'data' => $productos
        ], 200);


    } catch (\Exception $e) {

        return response()->json(['error' => $e->getMessage()], 500);

    }


});

Route::get('/sugerencias' , [ \App\Http\Controllers\suggestions_controller::class, 'index'])->name('sugerencias');
