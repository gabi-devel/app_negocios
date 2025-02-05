<?php

use App\Http\Controllers\CodBarrasController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\NegocioController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () { return view('home'); });

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/productos/cobrar', function () {
        return view('productos.cobrar');
    })->name('productos.cobrar');

    Route::get('/escaneo', function () {
        return view('productos.escaneo');
    })->name('escaneo.index');
    
    Route::resource('productos', ProductoController::class);
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');


});


Auth::routes();
Route::get('/login', function () { return view('auth.login'); })->name('login');


Route::post('/guardar-codigoBarra', [CodBarrasController::class, 'store']);
Route::post('/api/codigos', [CodBarrasController::class, 'store'])->name('codigos.store');




Route::get('/auth/negocios/create', [NegocioController::class, 'crearNegocioSiNoExiste'])->name('negocios.crear');
