<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIG - Sistema de Información Geográfica</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">


    <!-- Estilos personalizados -->
    <style>
body {
    background: linear-gradient(to right, #e0f7fa, #f1fcfc); /* degradado celeste pastel */
    font-family: 'Inter', sans-serif;
    color: #1a1a1a; /* texto gris oscuro para contraste */
}

.navbar {
    background-color: #a8dadc; /* celeste pastel */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.navbar-brand, .nav-link, .navbar-nav .nav-item .dropdown-toggle {
    color: #1a1a1a !important; /* texto oscuro */
    transition: color 0.3s ease;
}

.navbar-brand:hover, .nav-link:hover, .navbar-nav .nav-item .dropdown-toggle:hover {
    color: #007b83 !important; /* celeste más oscuro al pasar el mouse */
}

.footer {
    background-color: #b2ebf2; /* tono pastel suave */
    color: #1a1a1a;
    padding: 20px 0;
    text-align: center;
    margin-top: 30px;
}

.footer a {
    color: #1a1a1a;
    text-decoration: none;
}

.footer a:hover {
    color: #007b83;
}
</style>


    @stack('styles')
</head>
<body>
    <!-- NAV -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-globe me-2"></i> SIG
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('zonasriesgo.index') }}"><i class="fas fa-exclamation-triangle me-1"></i> Zonas Riesgo</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('zonasegs.index') }}"><i class="fas fa-shield-alt me-1"></i> Zonas Seguras</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('puntos.index') }}"><i class="fas fa-map-marker-alt me-1"></i> Puntos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('mapa.general') }}"><i class="fas fa-map me-1"></i> Mapa</a></li>
                        @elseif(auth()->user()->role === 'user')
                            <li class="nav-item"><a class="nav-link" href="{{ route('mapa.general') }}"><i class="fas fa-map me-1"></i> Ver Mapa</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('puntos.index') }}"><i class="fas fa-map-pin me-1"></i> Ver Puntos</a></li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-1"></i> Perfil</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item"><i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO -->
    <main class="container py-4">
        @yield('contenido')
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <small>© 2025 Sistema SIG | Desarrollado por Diego & Anthony</small>
        </div>
    </footer>

    <!-- JS Libs -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF-pqS3WBYs8eap_ykcP7BtlNX2kU2kvU&libraries=places&callback=initMap" async defer></script>

    @stack('scripts')
</body>
</html>
