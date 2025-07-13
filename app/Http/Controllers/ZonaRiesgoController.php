<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZonaRiesgo;
class ZonaRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zonas = ZonaRiesgo::all();
        return view('zonasriesgo.index', compact('zonas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('zonasriesgo.nuevo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel_riesgo' => 'required|in:bajo,medio,alto',
            'coordenadas' => 'required|string',
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'nivel_riesgo' => $request->nivel_riesgo,
            'coordenadas' => $request->coordenadas,
        ];

        ZonaRiesgo::create($datos);

        return redirect()->route('zonasriesgo.index')->with('message', 'Zona de riesgo creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $zonasriesgo = ZonaRiesgo::findOrFail($id);
        return view('zonasriesgo.editar', compact('zonasriesgo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel_riesgo' => 'required|in:bajo,medio,alto',
            'coordenadas' => 'required|string',
        ]);

        $zonasriesgo = ZonaRiesgo::findOrFail($id);

        $datos = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'nivel_riesgo' => $request->nivel_riesgo,
            'coordenadas' => $request->coordenadas,
        ];

        $zonasriesgo->update($datos);

        return redirect()->route('zonasriesgo.index')->with('message', 'Zona de riesgo actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zonasriesgo = ZonaRiesgo::findOrFail($id);
        $zonasriesgo->delete();
        return redirect()->route('zonasriesgo.index')->with('message', 'Zona de riesgo eliminada.');
    }
}
