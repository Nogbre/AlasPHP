<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'direccion_domiciliaria',
        'correo_electronico',
        'contrasena',
        'telefono',
        'ci',
        'estado',
        'rol',
    ];

    protected $hidden = [
        'contrasena',
    ];
}

