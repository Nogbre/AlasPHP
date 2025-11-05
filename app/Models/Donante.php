<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Donante
 *
 * @property $id_donante
 * @property $nombre
 * @property $tipo
 * @property $email
 * @property $telefono
 * @property $direccion
 * @property $fecha_registro
 * @property $deleted_at
 * @property $deleted_by
 *
 * @property Donacione[] $donaciones
 * @property SolicitudesRecoleccion[] $solicitudesRecoleccions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Donante extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'donantes';
    protected $primaryKey = 'id_donante';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = ['nombre', 'tipo', 'email', 'telefono', 'direccion', 'fecha_registro', 'deleted_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donaciones()
    {
        return $this->hasMany(\App\Models\Donacione::class, 'id_donante', 'id_donante');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesRecoleccions()
    {
        return $this->hasMany(\App\Models\SolicitudesRecoleccion::class, 'id_donante', 'id_donante');
    }
    
}
