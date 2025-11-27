<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\DonanteAuthController;
use App\Http\Controllers\Api\Auth\VoluntarioAuthController;
use App\Http\Controllers\Api\DonacionController;
use App\Http\Controllers\Api\CampanaController;
use App\Http\Controllers\Api\PuntoRecoleccionController;
use App\Http\Controllers\Api\AlmacenController;
use App\Http\Controllers\Api\EstanteController;
use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SolicitudRecoleccionController;
use App\Http\Controllers\Api\ImagenController;
use App\Http\Controllers\Api\UserController;

// Rutas públicas de autenticación
Route::post('/donante-auth/login', [DonanteAuthController::class, 'login']);
Route::post('/auth/login', [VoluntarioAuthController::class, 'login']);

// Ruta pública de inventario
Route::get('/inventario/por-producto', [InventarioController::class, 'getInventoryByProduct']);

// Rutas protegidas con autenticación Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/donante-auth/logout', [DonanteAuthController::class, 'logout']);
    Route::post('/auth/logout', [VoluntarioAuthController::class, 'logout']);
    
    // Usuarios
    Route::get('/users/{userId}', [UserController::class, 'show']);
    Route::apiResource('users', UserController::class);
    
    // Donaciones
    Route::post('/donaciones', [DonacionController::class, 'store']);
    Route::put('/donaciones-en-dinero/{id}', [DonacionController::class, 'updateMoneyDonation']);
    Route::get('/donantes/{id}/donaciones', [DonacionController::class, 'getByDonante']);
    Route::get('/donaciones/donante/{id}', [DonacionController::class, 'getByDonante']); // Alias para compatibilidad
    Route::get('/donaciones-en-dinero/getAllById/{id}', [DonacionController::class, 'getMoneyDonationsByDonante']);
    Route::get('/donaciones/dinero/donante/{id}', [DonacionController::class, 'getMoneyDonationsByDonante']); // Alias para compatibilidad
    Route::patch('/donaciones/estado/{id}', [DonacionController::class, 'updateEstado']);
    Route::apiResource('donaciones', DonacionController::class);
    
    // Campañas
    Route::get('/campanas', [CampanaController::class, 'index']);
    Route::apiResource('campanas', CampanaController::class)->except(['index']);
    
    // Puntos de recolección
    Route::get('/puntos-de-recoleccion/campana/{id}', [PuntoRecoleccionController::class, 'getByCampana']);
    Route::apiResource('puntos-de-recoleccion', PuntoRecoleccionController::class);
    
    // Almacenes
    Route::get('/almacenes', [AlmacenController::class, 'index']);
    Route::apiResource('almacenes', AlmacenController::class)->except(['index']);
    
    // Estantes
    Route::get('/estantes', [EstanteController::class, 'index']);
    Route::get('/estantes/almacen/{id}', [EstanteController::class, 'getByAlmacen']);
    Route::apiResource('estantes', EstanteController::class)->except(['index']);
    
    // Inventario
    Route::get('/inventario/stock', [InventarioController::class, 'getStock']);
    Route::get('/inventario/stock/articulo/{id}', [InventarioController::class, 'getStockByArticulo']);
    Route::get('/inventario/stock/estante/{id}', [InventarioController::class, 'getStockByEstante']);
    Route::apiResource('inventario', InventarioController::class);
    
    // Dashboard
    Route::get('/dashboard/total-donaciones', [DashboardController::class, 'getTotalDonaciones']);
    Route::get('/dashboard/donaciones-por-mes/{year}', [DashboardController::class, 'getDonacionesPorMes']);
    
    // Solicitudes de recolección
    Route::post('/solicitudesRecoleccion', [SolicitudRecoleccionController::class, 'store']);
    Route::apiResource('solicitudesRecoleccion', SolicitudRecoleccionController::class)->except(['store']);
    
    // Imágenes
    Route::post('/imagenes-solicitud-recogida', [ImagenController::class, 'upload']);
    Route::apiResource('imagenes-solicitud-recogida', ImagenController::class);
});

