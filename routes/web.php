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

// Rutas solo para Administrador
Route::middleware(['auth', 'can:ver-usuarios'])->group(function () {
    Route::resource('usuario', App\Http\Controllers\UsuarioController::class);
});

Route::middleware(['auth', 'can:ver-campanas'])->group(function () {
    Route::resource('campana', App\Http\Controllers\CampanaController::class);
});

Route::middleware(['auth', 'can:ver-puntos'])->group(function () {
    Route::resource('puntos-recoleccion', App\Http\Controllers\PuntosRecoleccionController::class);
});

Route::middleware(['auth', 'can:ver-categorias'])->group(function () {
    Route::resource('categorias-producto', App\Http\Controllers\CategoriasProductoController::class);
});

Route::middleware(['auth', 'can:ver-productos'])->group(function () {
    Route::resource('producto', App\Http\Controllers\ProductoController::class);
});

Route::middleware(['auth', 'can:ver-donantes'])->group(function () {
    Route::resource('donante', App\Http\Controllers\DonanteController::class);
});

// Rutas para Administrador y Almacenista
Route::middleware(['auth', 'can:ver-almacen'])->group(function () {
    Route::resource('almacene', App\Http\Controllers\AlmaceneController::class);
    Route::resource('estante', App\Http\Controllers\EstanteController::class);
    Route::resource('solicitudes-recoleccions', App\Http\Controllers\SolicitudesRecoleccionController::class);
    Route::resource('paquete', App\Http\Controllers\PaqueteController::class);
    Route::resource('registros-salida', App\Http\Controllers\RegistrosSalidaController::class);
    Route::post('donaciones/guardar', [App\Http\Controllers\DonacioneController::class, 'store'])->name('donaciones.guardar_manual');
    Route::resource('donaciones', App\Http\Controllers\DonacioneController::class);
    Route::resource('recolectores', App\Http\Controllers\RecolectoresController::class);
    
    // API routes for cascading dropdowns
    Route::get('api/almacenes/{id}/estantes', [App\Http\Controllers\AlmaceneController::class, 'getEstantes']);
    Route::get('api/estantes/{id}/espacios', [App\Http\Controllers\EstanteController::class, 'getEspacios']);
    Route::post('espacio/{id}/toggle-status', [App\Http\Controllers\EspacioController::class, 'toggleStatus'])->name('espacio.toggleStatus');
    Route::resource('espacio', App\Http\Controllers\EspacioController::class);
    
    // Rutas de reportes
    Route::get('reportes', [App\Http\Controllers\ReportesController::class, 'index'])->name('reportes.index');
    Route::get('reportes/donaciones-periodo', [App\Http\Controllers\ReportesController::class, 'donacionesPorPeriodo'])->name('reportes.donaciones.periodo');
    Route::get('reportes/inventario-almacen', [App\Http\Controllers\ReportesController::class, 'inventarioPorAlmacen'])->name('reportes.inventario.almacen');
    Route::get('reportes/solicitudes-recoleccion', [App\Http\Controllers\ReportesController::class, 'solicitudesRecoleccion'])->name('reportes.solicitudes');
    Route::get('reportes/salidas-productos', [App\Http\Controllers\ReportesController::class, 'salidasProductos'])->name('reportes.salidas');
    Route::get('reportes/campanas', [App\Http\Controllers\ReportesController::class, 'campanasReporte'])->name('reportes.campanas');
});
