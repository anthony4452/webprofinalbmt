<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZonaSeg;
use App\Models\ZonaRiesgo;
use App\Models\Puntos;
use PDF;
use QrCode;

class ReporteController extends Controller
{
    public function mapaGeneral()
    {
        $zonasSeguras = ZonaSeg::where('activo', true)->get();
        $zonasRiesgo = ZonaRiesgo::where('activo', true)->get();
        $puntosEncuentro = Puntos::where('activo', true)->get();

        return view('reportes.mapa-general', compact('zonasSeguras', 'zonasRiesgo', 'puntosEncuentro'));
    }

    public function generarReporte(Request $request)
    {
        $imagenMapa = $request->input('imagenMapa'); // base64 desde html2canvas
        $urlMapa = route('reportes.mapa-general');

        $zonasSeguras = ZonaSeg::where('activo', true)->get();
        $zonasRiesgo = ZonaRiesgo::where('activo', true)->get();
        $puntosEncuentro = Puntos::where('activo', true)->get();

        $qrSvg = QrCode::format('svg')->size(120)->margin(1)->generate($urlMapa);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $data = compact('imagenMapa', 'qrBase64', 'zonasSeguras', 'zonasRiesgo', 'puntosEncuentro');

        $pdf = PDF::loadView('reportes.reporte-pdf', $data)->setPaper('A4', 'portrait');

        return $pdf->download('reporte_mapa_' . now()->format('Ymd_His') . '.pdf');
    }
}
