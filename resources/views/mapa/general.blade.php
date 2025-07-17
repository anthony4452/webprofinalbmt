<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Mapa General de Zonas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <div class="mb-4 flex flex-wrap gap-4">
            <select id="filtroTipo" class="form-select">
                <option value="todos">Todas las categorías</option>
                <option value="riesgo">Zonas de Riesgo</option>
                <option value="segura">Zonas Seguras</option>
                <option value="punto">Puntos de Encuentro</option>
            </select>

            <select id="filtroRiesgo" class="form-select">
                <option value="todos">Todos los niveles</option>
                <option value="bajo">Bajo</option>
                <option value="medio">Medio</option>
                <option value="alto">Alto</option>
            </select>

            <button onclick="filtrarMapa()" class="bg-blue-600 text-white px-4 py-2 rounded">Filtrar</button>
        </div>

        <div id="mapa" style="height: 600px; width: 100%; border: 1px solid #ccc;"></div>
    </div>

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

            mostrarTodo();
        }

        function mostrarTodo() {
            limpiarCapas();

            zonasRiesgo.forEach(z => {
                const coords = JSON.parse(z.coordenadas);
                const poligono = new google.maps.Polygon({
                    paths: coords,
                    strokeColor: "#FF0000",
                    fillColor: "#FF9999",
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
                    title: p.nombre
                });
                capas.push(marcador);
            });
        }

        function limpiarCapas() {
            capas.forEach(c => c.setMap(null));
            capas = [];
        }

        function filtrarMapa() {
            const tipo = document.getElementById('filtroTipo').value;
            const riesgo = document.getElementById('filtroRiesgo').value;
            limpiarCapas();

            if (tipo === 'riesgo' || tipo === 'todos') {
                zonasRiesgo.forEach(z => {
                    if (riesgo === 'todos' || z.nivel_riesgo === riesgo) {
                        const coords = JSON.parse(z.coordenadas);
                        const poligono = new google.maps.Polygon({
                            paths: coords,
                            strokeColor: "#FF0000",
                            fillColor: "#FF9999",
                            fillOpacity: 0.5,
                            map: mapa
                        });
                        capas.push(poligono);
                    }
                });
            }

            if (tipo === 'segura' || tipo === 'todos') {
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
            }

            if (tipo === 'punto' || tipo === 'todos') {
                puntosEncuentro.forEach(p => {
                    const marcador = new google.maps.Marker({
                        position: { lat: parseFloat(p.latitud), lng: parseFloat(p.longitud) },
                        map: mapa,
                        title: p.nombre
                    });
                    capas.push(marcador);
                });
            }
        }

        window.onload = initMap;
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY"></script>
</x-app-layout>
