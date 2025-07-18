@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md my-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        {{ isset($zonaseg) ? 'Editar Zona Segura' : 'Nueva Zona Segura' }}
    </h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($zonaseg) ? route('zonasegs.update', $zonaseg) : route('zonasegs.store') }}" method="POST">
        @csrf
        @if (isset($zonaseg))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="nombre" class="font-semibold block mb-1">Nombre *</label>
            <input id="nombre" type="text" name="nombre" required
                class="form-input w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                value="{{ old('nombre', $zonaseg->nombre ?? '') }}">
        </div>

        <div class="mb-4">
            <label for="tipo_seguridad" class="font-semibold block mb-1">Tipo de Seguridad *</label>
            <select id="tipo_seguridad" name="tipo_seguridad" required
                class="form-select w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">-- Seleccione --</option>
                <option value="alarma" {{ old('tipo_seguridad', $zonaseg->tipo_seguridad ?? '') == 'alarma' ? 'selected' : '' }}>Alarma</option>
                <option value="vigilancia" {{ old('tipo_seguridad', $zonaseg->tipo_seguridad ?? '') == 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                <option value="barreras" {{ old('tipo_seguridad', $zonaseg->tipo_seguridad ?? '') == 'barreras' ? 'selected' : '' }}>Barreras</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="radio" class="font-semibold block mb-1">Radio (metros) *</label>
            <input id="radio" type="number" min="1" step="0.1" name="radio" required
                class="form-input w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                value="{{ old('radio', $zonaseg->radio ?? '') }}">
        </div>

        <div class="mb-4">
            <label for="latitud" class="font-semibold block mb-1">Latitud *</label>
            <input id="latitud" type="text" name="latitud" readonly required
                class="form-input w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                value="{{ old('latitud', $zonaseg->latitud ?? '') }}">
        </div>

        <div class="mb-4">
            <label for="longitud" class="font-semibold block mb-1">Longitud *</label>
            <input id="longitud" type="text" name="longitud" readonly required
                class="form-input w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                value="{{ old('longitud', $zonaseg->longitud ?? '') }}">
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" class="form-checkbox h-5 w-5 text-green-600"
                    {{ old('activo', $zonaseg->activo ?? true) ? 'checked' : '' }}>
                <span class="ml-2 font-semibold">Activo</span>
            </label>
        </div>

        <div class="mb-6">
            <label class="font-semibold block mb-2">Selecciona ubicación y radio en el mapa:</label>
            <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #4ade80; border-radius: 0.375rem;"></div>
        </div>

<div class="flex justify-between">
    <a href="{{ route('zonasegs.index') }}" class="bg-blue-700 hover:bg-blue-800 text-yellow-400 px-4 py-2 rounded shadow font-semibold">
        Cancelar
    </a>
    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-yellow-400 px-4 py-2 rounded shadow font-semibold">
        {{ isset($zonaseg) ? 'Actualizar Zona' : 'Guardar Zona' }}
    </button>
</div>

    </form>
</div>

@push('scripts')
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
            strokeColor: "#22c55e",
            fillColor: "#bbf7d0",
            fillOpacity: 0.5,
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

        // Set inputs on load
        actualizarInputs(centro.lat, centro.lng);
    }

    window.onload = initMap;
</script>
@endpush
@endsection
