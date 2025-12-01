<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('donante', App\Http\Controllers\DonanteController::class)->middleware('auth');
Route::resource('usuario', App\Http\Controllers\UsuarioController::class)->middleware('auth');
Route::resource('almacene', App\Http\Controllers\AlmaceneController::class)->middleware('auth');
Route::resource('estante', App\Http\Controllers\EstanteController::class)->middleware('auth');
Route::resource('campana', App\Http\Controllers\CampanaController::class)->middleware('auth');
Route::resource('puntos-recoleccion', App\Http\Controllers\PuntosRecoleccionController::class)->middleware('auth');
Route::resource('categorias-producto', App\Http\Controllers\CategoriasProductoController::class)->middleware('auth');
Route::resource('producto', App\Http\Controllers\ProductoController::class)->middleware('auth');
Route::resource('solicitudes-recoleccions', App\Http\Controllers\SolicitudesRecoleccionController::class)->middleware('auth');
Route::resource('paquete', App\Http\Controllers\PaqueteController::class)->middleware('auth');
Route::resource('registros-salida', App\Http\Controllers\RegistrosSalidaController::class)->middleware('auth');

Route::post('donaciones/guardar', [App\Http\Controllers\DonacioneController::class, 'store'])->name('donaciones.guardar_manual')->middleware('auth');
Route::resource('donaciones', App\Http\Controllers\DonacioneController::class)->middleware('auth');
Route::resource('recolectores', App\Http\Controllers\RecolectoresController::class)->middleware('auth');

// API routes for cascading dropdowns
Route::get('api/almacenes/{id}/estantes', [App\Http\Controllers\AlmaceneController::class, 'getEstantes'])->middleware('auth');
Route::get('api/estantes/{id}/espacios', [App\Http\Controllers\EstanteController::class, 'getEspacios'])->middleware('auth');
Route::post('espacio/{id}/toggle-status', [App\Http\Controllers\EspacioController::class, 'toggleStatus'])->name('espacio.toggleStatus')->middleware('auth');
Route::resource('espacio', App\Http\Controllers\EspacioController::class)->middleware('auth');

// Rutas de reportes
Route::get('reportes', [App\Http\Controllers\ReportesController::class, 'index'])->name('reportes.index')->middleware('auth');
Route::get('reportes/donaciones-periodo', [App\Http\Controllers\ReportesController::class, 'donacionesPorPeriodo'])->name('reportes.donaciones.periodo')->middleware('auth');
Route::get('reportes/inventario-almacen', [App\Http\Controllers\ReportesController::class, 'inventarioPorAlmacen'])->name('reportes.inventario.almacen')->middleware('auth');
Route::get('reportes/solicitudes-recoleccion', [App\Http\Controllers\ReportesController::class, 'solicitudesRecoleccion'])->name('reportes.solicitudes')->middleware('auth');
Route::get('reportes/salidas-productos', [App\Http\Controllers\ReportesController::class, 'salidasProductos'])->name('reportes.salidas')->middleware('auth');
Route::get('reportes/campanas', [App\Http\Controllers\ReportesController::class, 'campanasReporte'])->name('reportes.campanas')->middleware('auth');
