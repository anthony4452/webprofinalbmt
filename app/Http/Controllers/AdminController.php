<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZonaRiesgo;
use App\Models\ZonaSeg;
use App\Models\Puntos;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalZonasRiesgo' => ZonaRiesgo::count(),
            'totalZonasSeguras' => ZonaSeg::count(),
            'totalPuntos' => Puntos::count(),
            'totalUsuarios' => User::count(),
            'ultimasZonas' => ZonaRiesgo::latest()->take(5)->get(),
        ]);
    }
}
