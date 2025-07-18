<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Mapa General de Zonas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <div class="mb-4 flex flex-wrap gap-4">
            <!-- Filtro principal -->
            <select id="filtroTipo" class="form-select" onchange="mostrarFiltroEspecifico()">
                <option value="todos">Todas las categorías</option>
                <option value="riesgo">Zonas de Riesgo</option>
                <option value="segura">Zonas Seguras</option>
                <option value="punto">Puntos de Encuentro</option>
            </select>

            <!-- Filtro nivel de riesgo (solo para Zonas de Riesgo) -->
            <select id="filtroRiesgo" class="form-select" style="display:none;">
                <option value="todos">Todos los niveles</option>
                <option value="bajo">Bajo</option>
                <option value="medio">Medio</option>
                <option value="alto">Alto</option>
            </select>

            <!-- Filtro tipo seguridad (solo para Zonas Seguras) -->
            <select id="filtroTipoSeguridad" class="form-select" style="display:none;">
                <option value="todos">Todos los tipos</option>
                <option value="alarma">Alarma</option>
                <option value="vigilancia">Vigilancia</option>
                <option value="barreras">Barreras</option>
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
                    // Aquí no se filtra, se muestra todo directamente
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

</x-app-layout>
