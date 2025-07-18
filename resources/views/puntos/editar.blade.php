@extends('layouts.app')

@section('contenido')
<div class="container py-4" style="min-height: 80vh;">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            {{ isset($punto) ? 'Editar Punto de Encuentro' : 'Nuevo Punto de Encuentro' }}
        </h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded">
                <ul class="list-disc list-inside mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($punto) ? route('puntos.update', $punto) : route('puntos.store') }}" method="POST">
            @csrf
            @if(isset($punto))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="form-label fw-semibold">Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $punto->nombre ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Capacidad *</label>
                <input type="number" min="1" name="capacidad" class="form-control" value="{{ old('capacidad', $punto->capacidad ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Responsable *</label>
                <input type="text" name="responsable" class="form-control" value="{{ old('responsable', $punto->responsable ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Latitud *</label>
                <input type="text" name="latitud" id="latitud" class="form-control bg-light" value="{{ old('latitud', $punto->latitud ?? '') }}" readonly required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Longitud *</label>
                <input type="text" name="longitud" id="longitud" class="form-control bg-light" value="{{ old('longitud', $punto->longitud ?? '') }}" readonly required>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" name="activo" id="activo" class="form-check-input" {{ old('activo', $punto->activo ?? true) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="activo">Activo</label>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Selecciona ubicación en el mapa:</label>
                <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #a8dadc; border-radius: 6px;"></div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('puntos.index') }}" class="btn btn-secondary shadow-sm px-4">Cancelar</a>
                <button type="submit" class="btn btn-success shadow-sm px-4">
                    {{ isset($punto) ? 'Actualizar Punto' : 'Guardar Punto' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let mapa;
    let marcador;

    function initMap() {
        const centro = {
            lat: parseFloat("{{ $punto->latitud ?? '-0.9374805' }}"),
            lng: parseFloat("{{ $punto->longitud ?? '-78.6161327' }}")
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

        marcador.addListener('dragend', function(event) {
            document.getElementById("latitud").value = event.latLng.lat();
            document.getElementById("longitud").value = event.latLng.lng();
        });

        mapa.addListener("click", function(event) {
            marcador.setPosition(event.latLng);
            document.getElementById("latitud").value = event.latLng.lat();
            document.getElementById("longitud").value = event.latLng.lng();
        });

        // Setear lat/lng al cargar
        document.getElementById("latitud").value = marcador.getPosition().lat();
        document.getElementById("longitud").value = marcador.getPosition().lng();
    }

    window.onload = initMap;
</script>
@endpush

@endsection
