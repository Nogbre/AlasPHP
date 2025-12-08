<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\Role;
use App\Models\Usuario;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing roles from 'roles' table to Spatie's 'spatie_roles' table
        $existingRoles = Role::all();
        
        foreach ($existingRoles as $role) {
            SpatieRole::create([
                'name' => $role->nombre_rol,
                'guard_name' => 'web', // Solo web, no afecta API
            ]);
        }

        // Assign roles to existing users
        $usuarios = Usuario::whereNotNull('id_rol')->get();
        
        foreach ($usuarios as $usuario) {
            $roleName = $usuario->role?->nombre_rol;
            if ($roleName) {
                $usuario->assignRole($roleName);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all Spatie roles and role assignments
        \DB::table('model_has_roles')->truncate();
        SpatieRole::where('guard_name', 'web')->delete();
    }
};
