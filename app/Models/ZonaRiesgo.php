<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZonaRiesgo extends Model
{
    protected $table = 'zona_riesgos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'nivel_riesgo',
        'coordenadas',
        'activo',
    ];

}
