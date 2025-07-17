<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZonaSeg extends Model
{
    protected $fillable = [
        'nombre',
        'tipo_seguridad',
        'radio',
        'latitud',
        'longitud',
        'activo',
    ];
}
