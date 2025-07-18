<script>
    function cargarZonasRiesgo(filtro) {
        capas.riesgos.forEach(z => z.setMap(null));
        capas.riesgos = [];

        @foreach($zonasRiesgo as $riesgo)
            if (filtro === 'TODOS' || '{{ $riesgo->nivel }}' === filtro) {
                const puntos = [
                    { lat: {{ $riesgo->latitudUno }}, lng: {{ $riesgo->longitudUno }} },
                    { lat: {{ $riesgo->latitudDos }}, lng: {{ $riesgo->longitudDos }} },
                    { lat: {{ $riesgo->latitudTres }}, lng: {{ $riesgo->longitudTres }} },
                    { lat: {{ $riesgo->latitudCuatro }}, lng: {{ $riesgo->longitudCuatro }} },
                    { lat: {{ $riesgo->latitudCinco }}, lng: {{ $riesgo->longitudCinco }} }
                ];

                const color = {
                    'ALTO': '#FF0000',
                    'MEDIO': '#FFA500',
                    'BAJO': '#28a745'
                }['{{ $riesgo->nivel }}'] || '#000';

                const zona = new google.maps.Polygon({
                    paths: puntos,
                    strokeColor: color,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.4,
                    map: mapa
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <strong>{{ $riesgo->nombre }}</strong><br>
                        {{ $riesgo->descripcion }}<br>
                        Nivel: {{ $riesgo->nivel }}
                    `
                });

                zona.addListener('mouseover', (event) => {
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(mapa);
                });

                zona.addListener('mouseout', () => {
                    infoWindow.close();
                });

                capas.riesgos.push(zona);
            }
        @endforeach
    }
</script>
