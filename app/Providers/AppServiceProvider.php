<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Definir permisos basados en roles
        Gate::define('ver-usuarios', function ($user) {
            return $user->role?->nombre_rol === 'Administrador';
        });

        Gate::define('ver-campanas', function ($user) {
            // Administrador puede gestionar, Voluntario solo ver
            return in_array($user->role?->nombre_rol, ['Administrador', 'Voluntario']);
        });

        Gate::define('gestionar-campanas', function ($user) {
            return $user->role?->nombre_rol === 'Administrador';
        });

        Gate::define('ver-puntos', function ($user) {
            return $user->role?->nombre_rol === 'Administrador';
        });

        Gate::define('ver-categorias', function ($user) {
            return $user->role?->nombre_rol === 'Administrador';
        });

        Gate::define('ver-productos', function ($user) {
            return $user->role?->nombre_rol === 'Administrador';
        });

        Gate::define('ver-donantes', function ($user) {
            // Administrador y Voluntario pueden gestionar donantes
            return in_array($user->role?->nombre_rol, ['Administrador', 'Voluntario']);
        });

        // Permisos de almacén más granulares
        Gate::define('ver-almacen', function ($user) {
            // Todos pueden VER almacenes
            return in_array($user->role?->nombre_rol, ['Administrador', 'Almacenista', 'Voluntario']);
        });

        Gate::define('gestionar-almacen', function ($user) {
            // Solo Administrador puede CREAR/EDITAR/ELIMINAR almacenes
            return $user->role?->nombre_rol === 'Administrador';
        });

        // Permisos de donaciones
        Gate::define('registrar-donaciones', function ($user) {
            // Administrador, Almacenista y Voluntario pueden registrar donaciones
            return in_array($user->role?->nombre_rol, ['Administrador', 'Almacenista', 'Voluntario']);
        });

        Gate::define('consultar-donaciones', function ($user) {
            // Todos pueden consultar donaciones
            return in_array($user->role?->nombre_rol, ['Administrador', 'Almacenista', 'Voluntario']);
        });

        Gate::define('consultar-inventario', function ($user) {
            // Todos pueden consultar inventario
            return in_array($user->role?->nombre_rol, ['Administrador', 'Almacenista', 'Voluntario']);
        });
    }
}
