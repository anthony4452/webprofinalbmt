<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1, h2, h3 {
            margin-bottom: 10px;
        }
        .mapa-img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .qr-container {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h1>Reporte General de Seguridad</h1>

    @if($imagenMapa)
        <img class="mapa-img" src="{{ $imagenMapa }}" alt="Mapa General">
    @else
        <p><strong>[Mapa no disponible]</strong></p>
    @endif

    <h2>Zonas Seguras</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo Seguridad</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Radio (m)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($zonasSeguras as $z)
                <tr>
                    <td>{{ $z->nombre }}</td>
                    <td>{{ ucfirst($z->tipo_seguridad) }}</td>
                    <td>{{ $z->latitud }}</td>
                    <td>{{ $z->longitud }}</td>
                    <td>{{ $z->radio }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay zonas seguras registradas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Zonas de Riesgo</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Nivel</th>
                <th>Coordenadas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($zonasRiesgo as $z)
                <tr>
                    <td>{{ $z->nombre }}</td>
                    <td>{{ $z->descripcion }}</td>
                    <td>{{ ucfirst($z->nivel_riesgo) }}</td>
                    <td>
                        @php
                            $coords = json_decode($z->coordenadas, true);
                        @endphp
                        @if (is_array($coords))
                            @foreach($coords as $c)
                                ({{ $c['lat'] }}, {{ $c['lng'] }})<br>
                            @endforeach
                        @else
                            No válido
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay zonas de riesgo registradas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Puntos de Encuentro</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Capacidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($puntosEncuentro as $p)
                <tr>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->latitud }}</td>
                    <td>{{ $p->longitud }}</td>
                    <td>{{ $p->capacidad }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No hay puntos de encuentro registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="qr-container">
        <h3>Escanea para ver el mapa en línea</h3>
        @if($qrBase64)
            <img src="{{ $qrBase64 }}" width="120" height="120" alt="QR Mapa">
        @else
            <p><strong>[QR no disponible]</strong></p>
        @endif
    </div>
</body>
</html>
