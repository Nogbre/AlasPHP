<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Usuario
 *
 * @property $id_usuario
 * @property $nombres
 * @property $apellidos
 * @property $ci
 * @property $foto_ci
 * @property $licencia_conducir
 * @property $foto_licencia
 * @property $genero
 * @property $correo
 * @property $telefono
 * @property $direccion_domicilio
 * @property $contrasena
 * @property $estado
 * @property $entidad_pertenencia
 * @property $tipo_sangre
 * @property $id_rol
 * @property $fecha_registro
 *
 * @property Role $role
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Usuario extends Authenticatable
{
    use HasApiTokens;

    /** 👇 CLAVE: nombre de tabla y PK personalizada */
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;         // tu tabla usa fecha_registro, no created_at/updated_at
    public $incrementing = true;        // Laravel ya no pedirá el id manualmente
    protected $keyType = 'int';         // el id es entero

    /** Paginación por defecto */
    protected $perPage = 20;

    /**
     * Campos que se pueden llenar en masa (mass assignable)
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'ci',
        'foto_ci',
        'licencia_conducir',
        'foto_licencia',
        'genero',
        'correo',
        'telefono',
        'direccion_domicilio',
        'contrasena',
        'estado',
        'entidad_pertenencia',
        'tipo_sangre',
        'id_rol',
        'fecha_registro'
    ];

    /**
     * Campos ocultos en serialización JSON
     */
    protected $hidden = ['contrasena'];

    /**
     * Método requerido por Authenticatable para obtener la contraseña
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Relación con roles
     */
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'id_rol', 'id_rol');
    }
}
