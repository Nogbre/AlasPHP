<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
class Usuario extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_usuario', 'nombres', 'apellidos', 'ci', 'foto_ci', 'licencia_conducir', 'foto_licencia', 'genero', 'correo', 'telefono', 'direccion_domicilio', 'contrasena', 'estado', 'entidad_pertenencia', 'tipo_sangre', 'id_rol', 'fecha_registro'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'id_rol', 'id_rol');
    }
    
}
