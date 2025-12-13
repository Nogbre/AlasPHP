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

// Rutas para gestionar campañas (solo Administrador) - DEBE IR ANTES de las rutas con parámetros
Route::middleware(['auth', 'can:gestionar-campanas'])->group(function () {
    Route::get('campana/create', [App\Http\Controllers\CampanaController::class, 'create'])->name('campana.create');
    Route::post('campana', [App\Http\Controllers\CampanaController::class, 'store'])->name('campana.store');
    Route::get('campana/{campana}/edit', [App\Http\Controllers\CampanaController::class, 'edit'])->name('campana.edit');
    Route::put('campana/{campana}', [App\Http\Controllers\CampanaController::class, 'update'])->name('campana.update');
    Route::delete('campana/{campana}', [App\Http\Controllers\CampanaController::class, 'destroy'])->name('campana.destroy');
});

// Rutas para ver campañas (Administrador y Voluntario) - DESPUÉS de las rutas específicas
Route::middleware(['auth', 'can:ver-campanas'])->group(function () {
    Route::get('campana', [App\Http\Controllers\CampanaController::class, 'index'])->name('campana.index');
    Route::get('campana/{campana}', [App\Http\Controllers\CampanaController::class, 'show'])->name('campana.show');
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

// Rutas solo para Administrador (gestión de almacenes) - ANTES de las rutas con parámetros
Route::middleware(['auth', 'can:gestionar-almacen'])->group(function () {
    Route::get('almacene/create', [App\Http\Controllers\AlmaceneController::class, 'create'])->name('almacene.create');
    Route::post('almacene', [App\Http\Controllers\AlmaceneController::class, 'store'])->name('almacene.store');
    Route::get('almacene/{almacene}/edit', [App\Http\Controllers\AlmaceneController::class, 'edit'])->name('almacene.edit');
    Route::put('almacene/{almacene}', [App\Http\Controllers\AlmaceneController::class, 'update'])->name('almacene.update');
    Route::delete('almacene/{almacene}', [App\Http\Controllers\AlmaceneController::class, 'destroy'])->name('almacene.destroy');
});

// Rutas de solicitudes de recolección - create ANTES de show
Route::middleware(['auth', 'can:gestionar-solicitudes'])->group(function () {
    Route::get('solicitudes-recoleccions', [App\Http\Controllers\SolicitudesRecoleccionController::class, 'index'])->name('solicitudes-recoleccions.index');
    Route::get('solicitudes-recoleccions/create', [App\Http\Controllers\SolicitudesRecoleccionController::class, 'create'])->name('solicitudes-recoleccions.create');
    Route::post('solicitudes-recoleccions', [App\Http\Controllers\SolicitudesRecoleccionController::class, 'store'])->name('solicitudes-recoleccions.store');
    Route::get('solicitudes-recoleccions/{solicitudes_recoleccion}', [App\Http\Controllers\SolicitudesRecoleccionController::class, 'show'])->name('solicitudes-recoleccions.show');
});

Route::middleware(['auth', 'can:gestionar-almacen'])->group(function () {
    // Solo Admin y Almacenista pueden editar/eliminar solicitudes
    Route::get('solicitudes-recoleccions/{solicitudes_recoleccion}/edit', [App\Http\Controllers\SolicitudesRecoleccionController::class, 'edit'])->name('solicitudes-recoleccions.edit');
    Route::put('solicitudes-recoleccions/{solicitudes_recoleccion}', [App\Http\Controllers\SolicitudesRecoleccionController::class, 'update'])->name('solicitudes-recoleccions.update');
    Route::delete('solicitudes-recoleccions/{solicitudes_recoleccion}', [App\Http\Controllers\SolicitudesRecoleccionController::class, 'destroy'])->name('solicitudes-recoleccions.destroy');
});

// Rutas para Administrador, Almacenista y Voluntario - Rutas específicas ANTES que las dinámicas
Route::middleware(['auth', 'can:registrar-donaciones'])->group(function () {
    // Rutas específicas primero
    Route::get('paquete/pendientes', [App\Http\Controllers\PaqueteController::class, 'pendientes'])->name('paquete.pendientes');
    Route::post('donaciones/guardar', [App\Http\Controllers\DonacioneController::class, 'store'])->name('donaciones.guardar_manual');
    Route::post('espacio/{id}/toggle-status', [App\Http\Controllers\EspacioController::class, 'toggleStatus'])->name('espacio.toggleStatus');
    
    // API routes for cascading dropdowns
    Route::get('api/almacenes/{id}/estantes', [App\Http\Controllers\AlmaceneController::class, 'getEstantes']);
    Route::get('api/estantes/{id}/espacios', [App\Http\Controllers\EstanteController::class, 'getEspacios']);
    
    // Rutas de almacenes (solo ver)
    Route::get('almacene', [App\Http\Controllers\AlmaceneController::class, 'index'])->name('almacene.index');
    Route::get('almacene/{almacene}', [App\Http\Controllers\AlmaceneController::class, 'show'])->name('almacene.show');

    // Resource routes
    Route::resource('estante', App\Http\Controllers\EstanteController::class);
    Route::resource('paquete', App\Http\Controllers\PaqueteController::class);
    Route::resource('registros-salida', App\Http\Controllers\RegistrosSalidaController::class);
    Route::resource('donaciones', App\Http\Controllers\DonacioneController::class);
    Route::resource('recolectores', App\Http\Controllers\RecolectoresController::class);
    Route::resource('espacio', App\Http\Controllers\EspacioController::class);

    // Rutas de reportes
    Route::get('reportes', [App\Http\Controllers\ReportesController::class, 'index'])->name('reportes.index');
    Route::get('reportes/donaciones-periodo', [App\Http\Controllers\ReportesController::class, 'donacionesPorPeriodo'])->name('reportes.donaciones.periodo');
    Route::get('reportes/inventario-almacen', [App\Http\Controllers\ReportesController::class, 'inventarioPorAlmacen'])->name('reportes.inventario.almacen');
    Route::get('reportes/solicitudes-recoleccion', [App\Http\Controllers\ReportesController::class, 'solicitudesRecoleccion'])->name('reportes.solicitudes');
    Route::get('reportes/salidas-productos', [App\Http\Controllers\ReportesController::class, 'salidasProductos'])->name('reportes.salidas');
    Route::get('reportes/campanas', [App\Http\Controllers\ReportesController::class, 'campanasReporte'])->name('reportes.campanas');
});


// ========== HELPDESK WIDGET ==========
// Ruta generada por: php artisan helpdeskwidget:install
Route::get('helpdesk', function () {
    return view('helpdesk');
})->name('helpdesk')->middleware('auth');
