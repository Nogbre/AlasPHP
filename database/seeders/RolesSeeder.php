<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre_rol' => 'Administrador',
                'descripcion_rol' => 'Usuario con acceso completo al sistema',
            ],
            [
                'nombre_rol' => 'Voluntario',
                'descripcion_rol' => 'Voluntario que apoya en las actividades',
            ],
            [
                'nombre_rol' => 'Almacenista',
                'descripcion_rol' => 'Gestiona el inventario y almacenes',
            ],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['nombre_rol' => $rol['nombre_rol']],
                $rol
            );
        }
    }
}
