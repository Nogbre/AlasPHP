<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('donante', App\Http\Controllers\DonanteController::class)->middleware('auth');
Route::resource('usuario', App\Http\Controllers\UsuarioController::class)->middleware('auth');
Route::resource('almacene', App\Http\Controllers\AlmaceneController::class)->middleware('auth');
Route::resource('estante', App\Http\Controllers\EstanteController::class)->middleware('auth');
Route::resource('espacio', App\Http\Controllers\EspacioController::class)->middleware('auth');
Route::resource('campana', App\Http\Controllers\CampanaController::class)->middleware('auth');
Route::resource('puntos-recoleccion', App\Http\Controllers\PuntosRecoleccionController::class)->middleware('auth');
Route::resource('categorias-producto', App\Http\Controllers\CategoriasProductoController::class)->middleware('auth');
Route::resource('producto', App\Http\Controllers\ProductoController::class)->middleware('auth');
Route::resource('solicitudes-recoleccions', App\Http\Controllers\SolicitudesRecoleccionController::class)->middleware('auth');
Route::resource('paquete', App\Http\Controllers\PaqueteController::class)->middleware('auth');
Route::resource('registros-salida', App\Http\Controllers\RegistrosSalidaController::class)->middleware('auth');

Route::resource('donaciones', App\Http\Controllers\DonacioneController::class)->middleware('auth');
Route::resource('recolectores', App\Http\Controllers\RecolectoresController::class)->middleware('auth');



