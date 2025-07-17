<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ isset($zonaRiesgo) ? 'Editar Zona de Riesgo' : 'Nueva Zona de Riesgo' }}
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

        <form action="{{ isset($zonaRiesgo) ? route('zonasriesgo.update', $zonaRiesgo) : route('zonasriesgo.store') }}" method="POST">
            @csrf
            @if(isset($zonaRiesgo))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="font-semibold">Nombre *</label>
                <input type="text" name="nombre" class="form-input w-full" value="{{ old('nombre', $zonaRiesgo->nombre ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Descripción</label>
                <textarea name="descripcion" rows="2" class="form-input w-full">{{ old('descripcion', $zonaRiesgo->descripcion ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Nivel de Riesgo *</label>
                <select name="nivel_riesgo" class="form-select w-full" required>
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
                <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #ccc;"></div>
                <button type="button" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow" onclick="graficarZona()">Graficar Zona</button>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('zonasriesgo.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded shadow">Cancelar</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
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

            // Si hay coordenadas previas cargadas (editar)
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
                poligono.setMap(null); // eliminar si ya existe
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
</x-app-layout>
