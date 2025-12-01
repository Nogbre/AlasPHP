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
            return $user->role?->nombre_rol === 'Administrador';
        });

        Gate::define('ver-almacen', function ($user) {
            return in_array($user->role?->nombre_rol, ['Administrador', 'Almacenista']);
        });
    }
}
