<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Puntos;
use App\Models\ZonaRiesgo;
use App\Models\ZonaSeg;

class MapaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $puntosEncuentro = Puntos::where('activo', true)->get();
        $zonasRiesgo = ZonaRiesgo::where('activo', true)->get();  // corregido estado->activo
        $zonasSeguras = ZonaSeg::where('activo', true)->get();

        return view('mapa.general', compact('zonasRiesgo', 'zonasSeguras', 'puntosEncuentro'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
