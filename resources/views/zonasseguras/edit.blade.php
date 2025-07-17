<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ isset($zonasegura) ? 'Editar Zona Segura' : 'Nueva Zona Segura' }}
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

        <form action="{{ isset($zonasegura) ? route('zonasseguras.update', $zonasegura) : route('zonasseguras.store') }}" method="POST">
            @csrf
            @if(isset($zonasegura))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="font-semibold">Nombre *</label>
                <input type="text" name="nombre" class="form-input w-full" value="{{ old('nombre', $zonasegura->nombre ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Tipo de Seguridad *</label>
                <input type="text" name="tipo_seguridad" class="form-input w-full" value="{{ old('tipo_seguridad', $zonasegura->tipo_seguridad ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Radio (metros) *</label>
                <input type="number" min="1" step="0.1" name="radio" class="form-input w-full" value="{{ old('radio', $zonasegura->radio ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Latitud *</label>
                <input type="text" name="latitud" id="latitud" class="form-input w-full" value="{{ old('latitud', $zonasegura->latitud ?? '') }}" readonly required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Longitud *</label>
                <input type="text" name="longitud" id="longitud" class="form-input w-full" value="{{ old('longitud', $zonasegura->longitud ?? '') }}" readonly required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Estado</label><br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" class="form-checkbox" {{ old('activo', $zonasegura->activo ?? true) ? 'checked' : '' }}>
                    <span class="ml-2">Activo</span>
                </label>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Selecciona ubicación y radio en el mapa:</label>
                <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #ccc;"></div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('zonasseguras.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded shadow">Cancelar</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                    {{ isset($zonasegura) ? 'Actualizar Zona' : 'Guardar Zona' }}
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
                lat: parseFloat("{{ $zonasegura->latitud ?? '-0.9374805' }}"),
                lng: parseFloat("{{ $zonasegura->longitud ?? '-78.6161327' }}")
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
                radius: parseFloat("{{ $zonasegura->radio ?? 100 }}"),
                strokeColor: "#008000",
                fillColor: "#00FF00",
                fillOpacity: 0.35,
                map: mapa,
                editable: true,
            });

            // Vincular el círculo al marcador para que se mueva junto
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

            // Set inputs al cargar
            actualizarInputs(centro.lat, centro.lng);
        }

        window.onload = initMap;
    </script>
</x-app-layout>
