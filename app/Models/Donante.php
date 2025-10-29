<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Donante
 *
 * @property $id
 * @property $nombres
 * @property $apellido_paterno
 * @property $apellido_materno
 * @property $correo
 * @property $telefono
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Donante extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombres', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono'];


}
