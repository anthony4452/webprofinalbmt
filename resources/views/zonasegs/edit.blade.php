@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        {{ isset($zonaseg) ? 'Editar Zona Segura' : 'Nueva Zona Segura' }}
    </h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($zonaseg) ? route('zonasegs.update', $zonaseg) : route('zonasegs.store') }}" method="POST">
        @csrf
        @if(isset($zonaseg))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="font-semibold">Nombre *</label>
            <input type="text" name="nombre" class="form-input w-full" value="{{ old('nombre', $zonaseg->nombre ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Tipo de Seguridad *</label>
            <select name="tipo_seguridad" class="form-select w-full" required>
                <option value="">-- Seleccione --</option>
                <option value="alarma" {{ old('tipo_seguridad', $zonaseg->tipo_seguridad ?? '') == 'alarma' ? 'selected' : '' }}>Alarma</option>
                <option value="vigilancia" {{ old('tipo_seguridad', $zonaseg->tipo_seguridad ?? '') == 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                <option value="barreras" {{ old('tipo_seguridad', $zonaseg->tipo_seguridad ?? '') == 'barreras' ? 'selected' : '' }}>Barreras</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Radio (metros) *</label>
            <input type="number" min="1" step="0.1" name="radio" class="form-input w-full" value="{{ old('radio', $zonaseg->radio ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Latitud *</label>
            <input type="text" name="latitud" id="latitud" class="form-input w-full" value="{{ old('latitud', $zonaseg->latitud ?? '') }}" readonly required>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Longitud *</label>
            <input type="text" name="longitud" id="longitud" class="form-input w-full" value="{{ old('longitud', $zonaseg->longitud ?? '') }}" readonly required>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Estado</label><br>
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" class="form-checkbox" {{ old('activo', $zonaseg->activo ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Activo</span>
            </label>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Selecciona ubicación y radio en el mapa:</label>
            <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #2563eb; border-radius: 0.375rem;"></div>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('zonasegs.index') }}" class="bg-blue-700 hover:bg-blue-800 text-yellow-400 px-4 py-2 rounded shadow font-semibold">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-yellow-400 px-4 py-2 rounded shadow font-semibold">
                {{ isset($zonaseg) ? 'Actualizar Zona' : 'Guardar Zona' }}
            </button>
        </div>
    </form>
</div>

<script>
    let mapa;
    let circulo;
    let marcador;

    function initMap() {
        const centro = {
            lat: parseFloat("{{ $zonaseg->latitud ?? '-0.9374805' }}"),
            lng: parseFloat("{{ $zonaseg->longitud ?? '-78.6161327' }}")
        };

        mapa = new google.maps.Map(document.getElementById("mapa"), {
            center: centro,
            zoom: 15,
        });

        marcador = new google.maps.Marker({
            position: centro,
            map: mapa,
            draggable: true,
        });

        circulo = new google.maps.Circle({
            center: centro,
            radius: parseFloat("{{ $zonaseg->radio ?? 100 }}"),
            strokeColor: "#2563eb",
            fillColor: "#93c5fd",
            fillOpacity: 0.35,
            map: mapa,
            editable: true,
        });

        marcador.addListener('drag', function(event) {
            circulo.setCenter(event.latLng);
            actualizarInputs(event.latLng.lat(), event.latLng.lng());
        });

        circulo.addListener('radius_changed', function() {
            document.querySelector('input[name="radio"]').value = circulo.getRadius();
        });

        mapa.addListener('click', function(event) {
            marcador.setPosition(event.latLng);
            circulo.setCenter(event.latLng);
            actualizarInputs(event.latLng.lat(), event.latLng.lng());
        });

        function actualizarInputs(lat, lng) {
            document.getElementById("latitud").value = lat;
            document.getElementById("longitud").value = lng;
        }

        actualizarInputs(centro.lat, centro.lng);
    }

    window.onload = initMap;
</script>
@endsection
