<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Donacione
 *
 * @property $id_donacion
 * @property $id_donante
 * @property $tipo
 * @property $id_campana
 * @property $id_punto_recoleccion
 * @property $observaciones
 * @property $fecha
 *
 * @property DonacionDetalle[] $donacionDetalles
 * @property DonacionesDinero $donacionesDinero
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Donacione extends Model
{
    protected $table = 'donaciones';
    protected $primaryKey = 'id_donacion';
    public $timestamps = false;
    protected $perPage = 20;

    protected $fillable = [
        'id_donante',
        'tipo',
        'id_campana',
        'id_punto_recoleccion',
        'observaciones',
        'fecha'
    ];

    public function detalles()
    {
        return $this->hasMany(DonacionDetalle::class, 'id_donacion', 'id_donacion');
    }

    public function dinero()
    {
        return $this->hasOne(DonacionesDinero::class, 'id_donacion', 'id_donacion');
    }

    public function donante()
    {
        return $this->belongsTo(Donante::class, 'id_donante', 'id_donante');
    }
}
