<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Editar Zona de Riesgo</h2>
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

        <form action="{{ route('zonasriesgo.update', $zonasriesgo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="font-semibold">Nombre *</label>
                <input type="text" name="nombre" class="form-input w-full"
                       value="{{ old('nombre', $zonasriesgo->nombre) }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Descripción</label>
                <textarea name="descripcion" rows="2" class="form-input w-full">{{ old('descripcion', $zonasriesgo->descripcion) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Nivel de Riesgo *</label>
                <select name="nivel_riesgo" class="form-select w-full" required>
                    <option value="bajo" {{ old('nivel_riesgo', $zonasriesgo->nivel_riesgo) == 'bajo' ? 'selected' : '' }}>Bajo</option>
                    <option value="medio" {{ old('nivel_riesgo', $zonasriesgo->nivel_riesgo) == 'medio' ? 'selected' : '' }}>Medio</option>
                    <option value="alto" {{ old('nivel_riesgo', $zonasriesgo->nivel_riesgo) == 'alto' ? 'selected' : '' }}>Alto</option>
                </select>
            </div>

            <input type="hidden" name="coordenadas" id="coordenadas" value="{{ old('coordenadas', $zonasriesgo->coordenadas) }}">

            <div class="mb-4">
                <label class="font-semibold">Editar zona en el mapa:</label>
                <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #ccc;"></div>
                <button type="button" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow" onclick="graficarZona()">Graficar Zona</button>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('zonasriesgo.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded shadow">Cancelar</a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">Actualizar Zona</button>
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

            const coords = @json(json_decode($zonasriesgo->coordenadas));

            if (coords && coords.length) {
                const bounds = new google.maps.LatLngBounds();

                coords.forEach(coord => {
                    const posicion = new google.maps.LatLng(coord.lat, coord.lng);

                    const marcador = new google.maps.Marker({
                        position: posicion,
                        map: mapa,
                        draggable: true
                    });

                    marcadores.push(marcador);
                    bounds.extend(posicion);
                });

                mapa.fitBounds(bounds);

                graficarZona();
            }

            mapa.addListener("click", (event) => {
                const marcador = new google.maps.Marker({
                    position: event.latLng,
                    map: mapa,
                    draggable: true,
                });

                marcadores.push(marcador);
            });
        }

        function graficarZona() {
            if (poligono) {
                poligono.setMap(null);
            }

            const coordenadas = marcadores.map((marcador) => {
                return {
                    lat: marcador.getPosition().lat(),
                    lng: marcador.getPosition().lng()
                };
            });

            if (coordenadas.length < 3) {
                alert("Se necesitan al menos 3 puntos para graficar una zona.");
                return;
            }

            poligono = new google.maps.Polygon({
                paths: coordenadas,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#00FF00",
                fillOpacity: 0.35,
            });

            poligono.setMap(mapa);
            document.getElementById("coordenadas").value = JSON.stringify(coordenadas);
        }
        window.onload = function() {
        initMap();
     };
    </script>
</x-app-layout>
