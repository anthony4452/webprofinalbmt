@extends('layouts.app')

@section('contenido')
<div class="container py-4" style="min-height: 80vh;">

    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
        <select id="filtroTipo" class="form-select w-auto" onchange="mostrarFiltroEspecifico()">
            <option value="todos">Todas las categorías</option>
            <option value="riesgo">Zonas de Riesgo</option>
            <option value="segura">Zonas Seguras</option>
            <option value="punto">Puntos de Encuentro</option>
        </select>

        <select id="filtroRiesgo" class="form-select w-auto" style="display:none;">
            <option value="todos">Todos los niveles</option>
            <option value="bajo">Bajo</option>
            <option value="medio">Medio</option>
            <option value="alto">Alto</option>
        </select>

        <select id="filtroTipoSeguridad" class="form-select w-auto" style="display:none;">
            <option value="todos">Todos los tipos</option>
            <option value="alarma">Alarma</option>
            <option value="vigilancia">Vigilancia</option>
            <option value="barreras">Barreras</option>
        </select>

        <button onclick="filtrarMapa()" class="btn btn-primary shadow-sm px-4">
            Filtrar
        </button>
    </div>

    <div id="mapa" style="height: 600px; width: 100%; border: 1px solid #ced4da; border-radius: 6px;"></div>
</div>
@endsection

@push('styles')
<style>
    /* Opcional: mejorar apariencia selects y botones si quieres */
    .form-select {
        min-width: 180px;
    }
</style>
@endpush

@push('scripts')
<script>
    let mapa;
    let zonasRiesgo = @json($zonasRiesgo);
    let zonasSeguras = @json($zonasSeguras);
    let puntosEncuentro = @json($puntosEncuentro);
    let capas = [];

    function initMap() {
        mapa = new google.maps.Map(document.getElementById("mapa"), {
            center: { lat: -0.9374805, lng: -78.6161327 },
            zoom: 14,
        });

        mostrarFiltroEspecifico();
        mostrarTodo();
    }

    function mostrarFiltroEspecifico() {
        const tipo = document.getElementById('filtroTipo').value;

        document.getElementById('filtroRiesgo').style.display = 'none';
        document.getElementById('filtroTipoSeguridad').style.display = 'none';

        if (tipo === 'riesgo') {
            document.getElementById('filtroRiesgo').style.display = 'inline-block';
        } else if (tipo === 'segura') {
            document.getElementById('filtroTipoSeguridad').style.display = 'inline-block';
        }
    }

    function limpiarCapas() {
        capas.forEach(c => c.setMap(null));
        capas = [];
    }

    function mostrarTodo() {
        limpiarCapas();

        zonasRiesgo.forEach(z => {
            const coords = JSON.parse(z.coordenadas);

            let color = "#999";
            switch (z.nivel_riesgo) {
                case 'bajo':
                    color = "#4CAF50"; // verde
                    break;
                case 'medio':
                    color = "#FFC107"; // naranja
                    break;
                case 'alto':
                    color = "#F44336"; // rojo
                    break;
            }

            const poligono = new google.maps.Polygon({
                paths: coords,
                strokeColor: color,
                fillColor: color,
                fillOpacity: 0.5,
                map: mapa
            });
            capas.push(poligono);
        });

        zonasSeguras.forEach(z => {
            const circ = new google.maps.Circle({
                center: { lat: parseFloat(z.latitud), lng: parseFloat(z.longitud) },
                radius: parseFloat(z.radio),
                strokeColor: "#00FF00",
                fillColor: "#AAFFAA",
                fillOpacity: 0.5,
                map: mapa
            });
            capas.push(circ);
        });

        puntosEncuentro.forEach(p => {
            const marcador = new google.maps.Marker({
                position: { lat: parseFloat(p.latitud), lng: parseFloat(p.longitud) },
                map: mapa,
                title: p.nombre,
                icon: {
                    url: '/img/encuentro.png',
                    scaledSize: new google.maps.Size(32, 32)
                }
            });
            capas.push(marcador);
        });
    }

    function filtrarMapa() {
        const tipo = document.getElementById('filtroTipo').value;
        let filtroEspecifico = 'todos';

        if (tipo === 'riesgo') {
            filtroEspecifico = document.getElementById('filtroRiesgo').value;
        } else if (tipo === 'segura') {
            filtroEspecifico = document.getElementById('filtroTipoSeguridad').value;
        }

        limpiarCapas();

        if (tipo === 'riesgo' || tipo === 'todos') {
            zonasRiesgo.forEach(z => {
                if (filtroEspecifico === 'todos' || z.nivel_riesgo === filtroEspecifico) {
                    const coords = JSON.parse(z.coordenadas);

                    let color = "#999";
                    switch (z.nivel_riesgo) {
                        case 'bajo':
                            color = "#4CAF50"; // verde
                            break;
                        case 'medio':
                            color = "#FFC107"; // naranja
                            break;
                        case 'alto':
                            color = "#F44336"; // rojo
                            break;
                    }

                    const poligono = new google.maps.Polygon({
                        paths: coords,
                        strokeColor: color,
                        fillColor: color,
                        fillOpacity: 0.5,
                        map: mapa
                    });
                    capas.push(poligono);
                }
            });
        }

        if (tipo === 'segura' || tipo === 'todos') {
            zonasSeguras.forEach(z => {
                if (filtroEspecifico === 'todos' || z.tipo_seguridad === filtroEspecifico) {
                    const circ = new google.maps.Circle({
                        center: { lat: parseFloat(z.latitud), lng: parseFloat(z.longitud) },
                        radius: parseFloat(z.radio),
                        strokeColor: "#00FF00",
                        fillColor: "#AAFFAA",
                        fillOpacity: 0.5,
                        map: mapa
                    });
                    capas.push(circ);
                }
            });
        }

        if (tipo === 'punto' || tipo === 'todos') {
            puntosEncuentro.forEach(p => {
                const marcador = new google.maps.Marker({
                    position: { lat: parseFloat(p.latitud), lng: parseFloat(p.longitud) },
                    map: mapa,
                    title: p.nombre,
                    icon: {
                        url: '/img/encuentro.png',
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
                capas.push(marcador);
            });
        }
    }

    window.onload = initMap;
</script>
@endpush
