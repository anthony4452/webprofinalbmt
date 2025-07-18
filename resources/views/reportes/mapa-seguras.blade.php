<script>
    function cargarZonasSeguras(filtro) {
        capas.seguras.forEach(c => c.setMap(null));
        capas.seguras = [];

        @foreach($zonasSeguras as $zona)
            @if($zona->latitud && $zona->longitud && $zona->radio)
                if (filtro === 'TODOS' || '{{ $zona->tipo_seguridad }}' === filtro) {
                    const color = {
                        'BAJA': '#dc3545',
                        'MEDIA': '#ffc107',
                        'ALTA': '#28a745'
                    }['{{ $zona->tipo_seguridad }}'] || '#000';

                    const circulo = new google.maps.Circle({
                        strokeColor: color,
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: color,
                        fillOpacity: 0.35,
                        map: mapa,
                        center: { lat: {{ $zona->latitud }}, lng: {{ $zona->longitud }} },
                        radius: {{ $zona->radio }}
                    });

                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <strong>{{ $zona->nombre }}</strong><br>
                            Tipo: {{ $zona->tipo_seguridad }}<br>
                            Radio: {{ $zona->radio }} m
                        `
                    });

                    circulo.addListener('mouseover', () => {
                        infoWindow.setPosition(circulo.getCenter());
                        infoWindow.open(mapa);
                    });

                    circulo.addListener('mouseout', () => {
                        infoWindow.close();
                    });

                    capas.seguras.push(circulo);
                }
            @endif
        @endforeach
    }
</script>
