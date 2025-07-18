<script>
    function cargarPuntosEncuentro() {
        capas.puntos.forEach(m => m.setMap(null));
        capas.puntos = [];

        @foreach($puntosEncuentro as $punto)
            const marcador = new google.maps.Marker({
                position: { lat: {{ $punto->latitud }}, lng: {{ $punto->longitud }} },
                map: mapa,
                icon: 'https://icons.iconarchive.com/icons/hopstarter/sleek-xp-basic/48/User-Group-icon.png',
                title: "{{ $punto->nombre }}"
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <strong>{{ $punto->nombre }}</strong><br>
                    Capacidad: {{ $punto->capacidad }} personas
                `
            });

            marcador.addListener('mouseover', () => {
                infoWindow.open(mapa, marcador);
            });

            marcador.addListener('mouseout', () => {
                infoWindow.close();
            });

            capas.puntos.push(marcador);
        @endforeach
    }
</script>
