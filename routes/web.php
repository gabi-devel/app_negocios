<?php

use App\Http\Controllers\CodBarrasController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\NegocioController;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;
use Illuminate\Http\Request;


Route::get('/', function () { return view('home'); });

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/productos/cobrar', function () {
        return view('productos.cobrar');
    })->name('productos.cobrar');
    
    Route::resource('productos', ProductoController::class);
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');

    Route::get('/api/producto/{codigo}', [ProductoController::class, 'buscarProducto']);

    Route::get('/buscar-producto', [ProductoController::class, 'buscarProducto'])->name('productos.buscar');

});


Route::get('/buscar-producto', function (Request $request) {
    $codigo = $request->query('codigo_barra');
    $negocioId = auth()->user()->negocio_id; // Ajusta según tu estructura

    $producto = Producto::where('negocio_id', $negocioId)
                        ->where('codigo_barra', $codigo)
                        ->first();

    if ($producto) {
        return response()->json([
            'success' => true,
            'producto' => [
                'nombre' => $producto->nombre,
                'marca' => $producto->marca,
                'precio' => $producto->precio,
            ]
        ]);
    } else {
        return response()->json(['success' => false]);
    }
});


Auth::routes();
Route::get('/login', function () { return view('auth.login'); })->name('login');


Route::post('/guardar-codigoBarra', [CodBarrasController::class, 'store']);
Route::post('/api/codigos', [CodBarrasController::class, 'store'])->name('codigos.store');




Route::get('/auth/negocios/create', [NegocioController::class, 'crearNegocioSiNoExiste'])->name('negocios.crear');
