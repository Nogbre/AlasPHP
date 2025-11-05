<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PuntosRecoleccion
 *
 * @property $id_punto
 * @property $nombre
 * @property $direccion
 * @property $contacto
 *
 * @property Donacione[] $donaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PuntosRecoleccion extends Model
{
    
    protected $perPage = 20;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_punto';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'direccion', 'contacto'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donaciones()
    {
        // The foreign key on Donacione is assumed to be 'id_punto_recoleccion'
        // local key is 'id_punto' in this model.
        return $this->hasMany(\App\Models\Donacione::class, 'id_punto', 'id_punto');
    }
    
}
