<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DonacionDetalle
 *
 * @property $id_detalle
 * @property $id_donacion
 * @property $id_producto
 * @property $cantidad
 * @property $unidad_medida
 * @property $descripcion
 * @property $id_talla
 * @property $id_genero
 *
 * @property Producto $producto
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DonacionDetalle extends Model
{
    protected $table = 'donacion_detalles';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;
    protected $perPage = 20;

    protected $fillable = [
        'id_donacion',
        'id_producto',
        'cantidad',
        'unidad_medida',
        'descripcion',
        'id_talla',
        'id_genero'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function ubicaciones()
    {
        return $this->hasMany(UbicacionesDonacione::class, 'id_detalle', 'id_detalle');
    }
}
