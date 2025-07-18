<?php

namespace App\Http\Controllers;

use App\Models\ZonaRiesgo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;  // <-- Esta línea es necesaria

class ReporteController extends Controller
{
    public function exportarZonasPDF()
    {
        $zonas = ZonaRiesgo::all();
        $usuario = Auth::user();
    
        $googleApiKey = env('GOOGLE_MAPS_API_KEY');
        $baseUrl = "https://maps.googleapis.com/maps/api/staticmap";
        $size = "600x400";
        $zoom = 14;
    
        // Calcular centro (como antes)
        $allCoords = [];
        foreach ($zonas as $zona) {
            $coords = json_decode($zona->coordenadas, true);
            if ($coords) {
                foreach ($coords as $p) {
                    $allCoords[] = $p;
                }
            }
        }
    
        $countCoords = count($allCoords);
        if ($countCoords > 0) {
            $centerLat = array_sum(array_column($allCoords, 'lat')) / $countCoords;
            $centerLng = array_sum(array_column($allCoords, 'lng')) / $countCoords;
        } else {
            $centerLat = -0.93748;
            $centerLng = -78.61613;
        }
    
        $center = "{$centerLat},{$centerLng}";
    
        $paths = [];
    
        foreach ($zonas as $zona) {
            $coords = json_decode($zona->coordenadas, true);
            if (!$coords) continue;
    
            $pathCoords = [];
            foreach ($coords as $punto) {
                $pathCoords[] = "{$punto['lat']},{$punto['lng']}";
            }
            $pathCoords[] = "{$coords[0]['lat']},{$coords[0]['lng']}"; // cerrar polígono
    
            switch ($zona->nivel_riesgo) {
                case 'bajo': $color = '0x4CAF5080'; break;
                case 'medio': $color = '0xFFC10780'; break;
                case 'alto': $color = '0xF4433680'; break;
                default: $color = '0x99999980';
            }
    
            $path = "color:{$color}|weight:2|fillcolor:{$color}|" . implode('|', $pathCoords);
            $paths[] = "path=" . urlencode($path);
        }
    
        $pathsQuery = implode('&', $paths);
    
        $mapUrl = "{$baseUrl}?center={$center}&zoom={$zoom}&size={$size}&{$pathsQuery}&key={$googleApiKey}";
    
        // Decodificar caracteres html para evitar problemas con &amp;
        $mapUrl = html_entity_decode($mapUrl);
    
        // Obtener imagen con Http client de Laravel
        $response = Http::get($mapUrl);
    
        if ($response->ok()) {
            $mapContent = $response->body();
            $mapBase64 = 'data:image/png;base64,' . base64_encode($mapContent);
        } else {
            $mapBase64 = null; // No se pudo obtener la imagen
        }
    
        $urlConsulta = route('mapa.general');
    
        $pdf = Pdf::loadView('reportes.zonas_pdf', [
            'zonas' => $zonas,
            'usuario' => $usuario,
            'url' => $urlConsulta,
            'mapImageBase64' => $mapBase64
        ]);
    
        return $pdf->download('reporte_zonas.pdf');
    }
    
}
