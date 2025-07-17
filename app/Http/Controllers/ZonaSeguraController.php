<?php
namespace App\Http\Controllers;

use App\Models\ZonasSeguras;
use Illuminate\Http\Request;

class ZonaSeguraController extends Controller
{
    public function index()
    {
        $zonasSeguras = ZonasSeguras::all();
        return view('zonasseguras.index', compact('zonasSeguras'));
    }

    public function create()
    {
        return view('zonasseguras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'radio' => 'required|numeric|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'tipo_seguridad' => 'required|string|max:255',
        ]);

        ZonasSeguras::create($request->all());

        return redirect()->route('zonasseguras.index')->with('success', 'Zona segura creada correctamente');
    }

    public function edit(ZonasSeguras $zonasegura)
    {
        return view('zonasseguras.edit', compact('zonasegura'));
    }

    public function update(Request $request, ZonasSeguras $zonasegura)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'radio' => 'required|numeric|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'tipo_seguridad' => 'required|string|max:255',
        ]);

        $zonasegura->update($request->all());

        return redirect()->route('zonasseguras.index')->with('success', 'Zona segura actualizada correctamente');
    }

    public function destroy(ZonasSeguras $zonasegura)
    {
        $zonasegura->delete();

        return redirect()->route('zonasseguras.index')->with('success', 'Zona segura eliminada correctamente');
    }
}
