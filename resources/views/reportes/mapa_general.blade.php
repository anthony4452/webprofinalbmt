@extends('layouts.app')

@section('contenido')
<div class="container py-4">
    <h2>Mapa General</h2>
    <button class="btn btn-success my-3" onclick="generarPDF()">Generar PDF</button>
    <form id="formReporte" method="POST" action="{{ route('reportes.generar') }}">
        @csrf
        <input type="hidden" name="imagenMapa" id="imagenMapa">
    </form>

    <div id="mapa" style="height: 600px;"></div>
</div>
@endsection

@push('scripts')
    <!-- HTML2Canvas para capturar el mapa -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

let mapa;

function initMap() {
    mapa = new google.maps.Map(document.getElementById("mapa"), {
        center: { lat: -0.9374805, lng: -78.6161327 },
        zoom: 14,
    });

    @foreach ($zonasSeguras as $z)
        new google.maps.Circle({
            center: { lat: {{ $z->latitud }}, lng: {{ $z->longitud }} },
            radius: {{ $z->radio }},
            fillColor: '#00FF00',
            strokeColor: '#00FF00',
            fillOpacity: 0.4,
            map: mapa
        });
    @endforeach

    @foreach ($zonasRiesgo as $z)
        const coords = {!! $z->coordenadas !!};
        new google.maps.Polygon({
            paths: coords,
            strokeColor: "#FF0000",
            fillColor: "#FF0000",
            fillOpacity: 0.4,
            map: mapa
        });
    @endforeach

    @foreach ($puntosEncuentro as $p)
        new google.maps.Marker({
            position: { lat: {{ $p->latitud }}, lng: {{ $p->longitud }} },
            title: "{{ $p->nombre }}",
            map: mapa
        });
    @endforeach
}

<script>
    function generarPDF() {
        const mapa = document.getElementById('mapa');
        html2canvas(mapa, {
            useCORS: true,
            backgroundColor: null
        }).then(canvas => {
            const base64image = canvas.toDataURL("image/png");
            document.getElementById("imagenMapa").value = base64image;
            document.getElementById("formReporte").submit();
        });
    }
</script>

