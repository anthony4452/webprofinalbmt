<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reporte de Zonas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .usuario-info { margin-bottom: 30px; background: #f9f9f9; padding: 10px; border: 1px solid #ddd; }
        .mapa { text-align: center; margin-bottom: 20px; }
        .zona { margin-bottom: 10px; }
        .qr-code { margin-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Zonas de Riesgo y Seguridad</h1>
    </div>

    <div class="usuario-info">
        <strong>Reporte generado por:</strong><br>
        Nombre: {{ $usuario->name }}<br>
        Rol: {{ ucfirst($usuario->role) }}<br>
        Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

    <div class="mapa">
        <h3>Mapa General de Zonas</h3>
        @if ($mapImageBase64)
            <img src="{{ $mapImageBase64 }}" alt="Mapa con zonas" style="width:100%; max-width:600px; border:1px solid #ccc;">
        @else
            <p>No se pudo cargar el mapa.</p>
        @endif
    </div>

    <div>
        <h3>Listado de Zonas de Riesgo:</h3>
        @foreach ($zonas as $zona)
            <div class="zona">
                <strong>{{ $zona->nombre }}</strong><br>
                Nivel de riesgo: {{ ucfirst($zona->nivel_riesgo) }}<br>
                Coordenadas: {{ $zona->coordenadas }}
            </div>
        @endforeach
    </div>

    <div style="margin-top: 40px;">
        <strong>Consulta en línea:</strong><br>
        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(120)->generate($url)) !!}" class="qr-code" alt="QR Code">
        <br>{{ $url }}
    </div>

</body>
</html>
