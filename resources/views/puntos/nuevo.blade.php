<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ isset($punto) ? 'Editar Punto de Encuentro' : 'Nuevo Punto de Encuentro' }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded">
                <ul class="list-disc list-inside">
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
                <label class="font-semibold">Nombre *</label>
                <input type="text" name="nombre" class="form-input w-full" value="{{ old('nombre', $punto->nombre ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Capacidad *</label>
                <input type="text" name="capacidad" class="form-input w-full" value="{{ old('capacidad', $punto->capacidad ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Responsable *</label>
                <input type="text" name="responsable" class="form-input w-full" value="{{ old('responsable', $punto->responsable ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Latitud *</label>
                <input type="text" name="latitud" id="latitud" class="form-input w-full" value="{{ old('latitud', $punto->latitud ?? '') }}" readonly required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Longitud *</label>
                <input type="text" name="longitud" id="longitud" class="form-input w-full" value="{{ old('longitud', $punto->longitud ?? '') }}" readonly required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Estado</label><br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" class="form-checkbox" {{ old('activo', $punto->activo ?? true) ? 'checked' : '' }}>
                    <span class="ml-2">Activo</span>
                </label>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Selecciona ubicación en el mapa:</label>
                <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #ccc;"></div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('puntos.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded shadow">Cancelar</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    {{ isset($punto) ? 'Actualizar Punto' : 'Guardar Punto' }}
                </button>
            </div>
        </form>
    </div>

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

            // Actualizar lat/lng al mover el marcador
            marcador.addListener('dragend', function(event) {
                document.getElementById("latitud").value = event.latLng.lat();
                document.getElementById("longitud").value = event.latLng.lng();
            });

            // Click en el mapa para mover marcador
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
</x-app-layout>
