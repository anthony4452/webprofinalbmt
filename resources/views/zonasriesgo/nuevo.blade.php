@extends('layouts.app')

@section('contenido')
<style>
    .form-container {
        background-color: #e0f7fa; /* fondo celeste pastel */
        color: #000; /* texto negro */
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        max-width: 720px;
        margin: 2rem auto;
    }

    label {
        font-weight: 600;
        color: #000;
    }

    input.form-input,
    textarea.form-input,
    select.form-select {
        background-color: #ffffff;
        border: 1px solid #a8dadc;
        color: #000;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        width: 100%;
        transition: border-color 0.3s ease;
    }

    input.form-input:focus,
    textarea.form-input:focus,
    select.form-select:focus {
        border-color: #007b83;
        outline: none;
        box-shadow: 0 0 5px #007b83;
        background-color: #f0fefe;
    }

    .form-checkbox {
        accent-color: #007b83;
        width: 1.2em;
        height: 1.2em;
    }

    .btn-blue {
        background-color: #007bff;
        color: white;
        transition: background-color 0.3s ease;
    }

    .btn-blue:hover {
        background-color: #0056b3;
    }

    .btn-green {
        background-color: #198754;
        color: white;
        transition: background-color 0.3s ease;
    }

    .btn-green:hover {
        background-color: #157347;
    }

    .btn-gray {
        background-color: #adb5bd;
        color: #000;
        transition: background-color 0.3s ease;
    }

    .btn-gray:hover {
        background-color: #889096;
    }

    .error-box {
        background-color: #ffe0e0;
        color: #8b0000;
        border: 1px solid #f5c2c7;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }

    #mapa {
        border: 2px solid #a8dadc;
        border-radius: 0.375rem;
    }
</style>

<div class="form-container">
    <h2 class="text-xl font-bold mb-4">
        {{ isset($zonaRiesgo) ? 'Editar Zona de Riesgo' : 'Nueva Zona de Riesgo' }}
    </h2>

    @if($errors->any())
        <div class="error-box">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($zonaRiesgo) ? route('zonasriesgo.update', $zonaRiesgo) : route('zonasriesgo.store') }}" method="POST">
        @csrf
        @if(isset($zonaRiesgo))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="font-semibold">Nombre *</label>
            <input type="text" name="nombre" class="form-input" value="{{ old('nombre', $zonaRiesgo->nombre ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Descripción</label>
            <textarea name="descripcion" rows="2" class="form-input">{{ old('descripcion', $zonaRiesgo->descripcion ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Nivel de Riesgo *</label>
            <select name="nivel_riesgo" class="form-select" required>
                <option value="">-- Seleccione --</option>
                <option value="bajo" {{ old('nivel_riesgo', $zonaRiesgo->nivel_riesgo ?? '') == 'bajo' ? 'selected' : '' }}>Bajo</option>
                <option value="medio" {{ old('nivel_riesgo', $zonaRiesgo->nivel_riesgo ?? '') == 'medio' ? 'selected' : '' }}>Medio</option>
                <option value="alto" {{ old('nivel_riesgo', $zonaRiesgo->nivel_riesgo ?? '') == 'alto' ? 'selected' : '' }}>Alto</option>
            </select>
        </div>

        <input type="hidden" name="coordenadas" id="coordenadas" value="{{ old('coordenadas', isset($zonaRiesgo) ? $zonaRiesgo->coordenadas : '') }}">

        <div class="mb-4">
            <label class="font-semibold">Activo</label><br>
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" class="form-checkbox" {{ old('activo', $zonaRiesgo->activo ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Activo</span>
            </label>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Dibuja la zona en el mapa:</label>
            <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #444; border-radius: 0.375rem;"></div>
            <button type="button" class="btn-blue mt-3" onclick="graficarZona()">Graficar Zona</button>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('zonasriesgo.index') }}" class="btn-gray px-4 py-2 rounded shadow">Cancelar</a>
            <button type="submit" class="btn-green px-4 py-2 rounded shadow">
                {{ isset($zonaRiesgo) ? 'Actualizar Zona' : 'Guardar Zona' }}
            </button>
        </div>
    </form>
</div>

<script>
    let mapa;
    let marcadores = [];
    let poligono = null;

    function initMap() {
        const centro = { lat: -0.9374805, lng: -78.6161327 };

        mapa = new google.maps.Map(document.getElementById("mapa"), {
            center: centro,
            zoom: 15,
        });

        let coords = @json(old('coordenadas', isset($zonaRiesgo) ? $zonaRiesgo->coordenadas : ''));

        if (coords) {
            try {
                let puntos = JSON.parse(coords);

                puntos.forEach(punto => {
                    let marker = new google.maps.Marker({
                        position: punto,
                        map: mapa,
                        draggable: true,
                    });

                    marker.addListener('dragend', actualizarCoordenadas);
                    marcadores.push(marker);
                });

                dibujarPoligono();
                ajustarCentro(puntos);
            } catch (e) {
                console.error('Error al cargar coordenadas:', e);
            }
        }

        mapa.addListener("click", (event) => {
            const marcador = new google.maps.Marker({
                position: event.latLng,
                map: mapa,
                draggable: true,
            });

            marcador.addListener('dragend', actualizarCoordenadas);

            marcadores.push(marcador);
            actualizarCoordenadas();
        });
    }

    function graficarZona() {
        if (poligono) {
            poligono.setMap(null);
        }

        if (marcadores.length < 3) {
            alert("Debes colocar al menos 3 puntos para formar una zona.");
            return;
        }

        dibujarPoligono();
        actualizarCoordenadas();
    }

    function dibujarPoligono() {
        const pathCoords = marcadores.map(m => m.getPosition());
        poligono = new google.maps.Polygon({
            paths: pathCoords,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#00FF00",
            fillOpacity: 0.35,
        });

        poligono.setMap(mapa);
    }

    function actualizarCoordenadas() {
        const coords = marcadores.map(marcador => {
            return {
                lat: marcador.getPosition().lat(),
                lng: marcador.getPosition().lng()
            };
        });

        document.getElementById("coordenadas").value = JSON.stringify(coords);

        if (poligono) {
            poligono.setMap(null);
        }
        dibujarPoligono();
    }

    function ajustarCentro(puntos) {
        const bounds = new google.maps.LatLngBounds();
        puntos.forEach(p => bounds.extend(p));
        mapa.fitBounds(bounds);
    }

    window.onload = initMap;
</script>
@endsection