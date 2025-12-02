<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el rol de Administrador
        $rolAdmin = Role::where('nombre_rol', 'Administrador')->first();

        if (!$rolAdmin) {
            $this->command->error('No existe el rol de Administrador. Ejecuta primero el RolesSeeder.');
            return;
        }

        // Verificar si ya existe el usuario
        $usuarioExistente = Usuario::where('correo', 'admin123456@gmail.com')->first();

        if ($usuarioExistente) {
            $this->command->info('El usuario administrador ya existe.');
            return;
        }

        // Crear usuario administrador
        Usuario::create([
            'nombres' => 'Administrador',
            'apellidos' => 'Sistema',
            'ci' => '00000000',
            'foto_ci' => null,
            'licencia_conducir' => null,
            'foto_licencia' => null,
            'genero' => 'Otro',
            'correo' => 'admin123456@gmail.com',
            'telefono' => '00000000',
            'direccion_domicilio' => 'Oficina Central',
            'contrasena' => Hash::make('admin123456'),
            'estado' => 'Activo',
            'entidad_pertenencia' => null,
            'tipo_sangre' => null,
            'id_rol' => $rolAdmin->id_rol,
            'is_recolector' => false,
            'fecha_registro' => Carbon::now(),
        ]);

        $this->command->info('Usuario administrador creado exitosamente.');
        $this->command->info('Email: admin123456@gmail.com');
        $this->command->info('Contraseña: admin123456');
    }
}
