<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puntos; // Asegúrate de que el modelo Puntos esté correctamente importado


class PuntosController extends Controller
{
    public function index()
    {
        $puntos = Puntos::all();
        return view('puntos.index', compact('puntos'));
    }

    public function create()
    {
        return view('puntos.nuevo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'capacidad' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'responsable' => 'required',
        ]);

        $data = $request->all();
        $data['activo'] = $request->has('activo');

        Puntos::create($data);

        return redirect()->route('puntos.index')->with('success', 'Punto creado correctamente');
    }

    public function edit(Puntos $punto)
    {
        return view('puntos.editar', compact('punto'));
    }

    public function update(Request $request, Puntos $punto)
    {
        $request->validate([
            'nombre' => 'required',
            'capacidad' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'responsable' => 'required',
        ]);

        $data = $request->all();
        $data['activo'] = $request->has('activo');

        $punto->update($data);

        return redirect()->route('puntos.index')->with('success', 'Punto actualizado correctamente');
    }

    public function destroy(Puntos $punto)
    {
        $punto->delete();
        return redirect()->route('puntos.index')->with('success', 'Punto eliminado correctamente');
    }
}