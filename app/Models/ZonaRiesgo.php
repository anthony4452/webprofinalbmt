<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZonaRiesgo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'nivel_riesgo',
        'coordenadas',
    ];
}
