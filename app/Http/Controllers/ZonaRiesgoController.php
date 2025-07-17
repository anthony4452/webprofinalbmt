<?php

namespace App\Http\Controllers;

use App\Models\ZonaRiesgo;
use Illuminate\Http\Request;

class ZonaRiesgoController extends Controller
{
    public function index()
    {
        $zonas = ZonaRiesgo::all();
        return view('zonasriesgo.index', compact('zonas'));
    }

    public function create()
    {
        return view('zonasriesgo.nuevo');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel_riesgo' => 'required|in:bajo,medio,alto',
            'coordenadas' => 'required|string',
        ]);

        $validatedData['activo'] = $request->has('activo');

        ZonaRiesgo::create($validatedData);

        return redirect()->route('zonasriesgo.index')->with('success', 'Zona de riesgo creada correctamente.');
    }

    public function edit(ZonaRiesgo $zonasriesgo)
    {
        return view('zonasriesgo.editar', ['zonaRiesgo' => $zonasriesgo]);
    }





    public function update(Request $request, ZonaRiesgo $zonasriesgo)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel_riesgo' => 'required|in:bajo,medio,alto',
            'coordenadas' => 'required|string',
        ]);

        $validatedData['activo'] = $request->has('activo');

        $zonasriesgo->update($validatedData);

        return redirect()->route('zonasriesgo.index')->with('success', 'Zona de riesgo actualizada correctamente.');
    }

    public function destroy(ZonaRiesgo $zonasriesgo)
    {
        $zonasriesgo->delete();
        return redirect()->route('zonasriesgo.index')->with('success', 'Zona eliminada correctamente');
    }
}
