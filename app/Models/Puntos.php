<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Puntos extends Model
{
    protected $fillable = [
        'nombre',
        'capacidad',
        'latitud',
        'longitud',
        'responsable',
        'activo',
    ];
}