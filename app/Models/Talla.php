<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table = 'tallas';
    protected $primaryKey = 'id_talla';
    public $timestamps = false;

    protected $fillable = ['talla'];
}
