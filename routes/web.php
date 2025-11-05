<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('donantes', App\Http\Controllers\DonanteController::class)->middleware('auth');
Route::resource('usuarios', App\Http\Controllers\UsuarioController::class)->middleware('auth');
Route::resource('almacene', App\Http\Controllers\AlmaceneController::class)->middleware('auth');
Route::resource('estante', App\Http\Controllers\EstanteController::class)->middleware('auth');
Route::resource('espacio', App\Http\Controllers\EspacioController::class)->middleware('auth');
Route::resource('campana', App\Http\Controllers\CampanaController::class)->middleware('auth');
Route::resource('puntos-recoleccion', App\Http\Controllers\PuntosRecoleccionController::class)->middleware('auth');
Route::resource('categorias-producto', App\Http\Controllers\CategoriasProductoController::class)->middleware('auth');
Route::resource('producto', App\Http\Controllers\ProductoController::class)->middleware('auth');


