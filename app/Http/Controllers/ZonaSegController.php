<?php

namespace App\Http\Controllers;

use App\Models\ZonaSeg;
use Illuminate\Http\Request;

class ZonaSegController extends Controller
{
    public function index()
    {
        $zonasegs = ZonaSeg::all();
        return view('zonasegs.index', compact('zonasegs'));
    }

    public function create()
    {
        return view('zonasegs.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_seguridad' => 'required|string|max:255',
            'radio' => 'required|numeric|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            // 'activo' no lo validamos porque es checkbox, lo controlamos abajo
        ]);

        // Checkbox activo: si está marcado => true, sino => false
        $validatedData['activo'] = $request->has('activo');

        ZonaSeg::create($validatedData);

        return redirect()->route('zonasegs.index')->with('success', 'Zona segura creada correctamente');
    }

    public function edit(ZonaSeg $zonaseg)
    {
        return view('zonasegs.edit', compact('zonaseg'));
    }

    public function update(Request $request, ZonaSeg $zonaseg)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_seguridad' => 'required|string|max:255',
            'radio' => 'required|numeric|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        $validatedData['activo'] = $request->has('activo');

        $zonaseg->update($validatedData);

        return redirect()->route('zonasegs.index')->with('success', 'Zona segura actualizada correctamente');
    }

    public function destroy(ZonaSeg $zonaseg)
    {
        $zonaseg->delete();

        return redirect()->route('zonasegs.index')->with('success', 'Zona segura eliminada correctamente');
    }
}
