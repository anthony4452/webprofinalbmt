<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>SIG - Sistema de Información Geográfica</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />

    <!-- Estilos personalizados -->
    <style>
        /* Body y tipografía */
        body {
            background: linear-gradient(to right, #e0f7fa, #f1fcfc);
            font-family: 'Inter', sans-serif;
            color: #1a1a1a;
            margin: 0;
            padding-top: 70px; /* espacio para navbar fijo */
        }

            /* --- NAVBAR --- */
    nav.navbar-custom {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 1050;
      background: rgba(255 255 255 / 0.15);
      backdrop-filter: saturate(180%) blur(10px);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
      transition: background-color 0.4s ease, box-shadow 0.4s ease;
      padding: 1rem 2rem;
    }
    nav.navbar-custom.scrolled {
      background: #007b83;
      box-shadow: 0 8px 32px 0 rgba(0, 123, 131, 0.5);
    }
    nav.navbar-custom .navbar-brand {
      font-weight: 700;
      font-size: 1.8rem;
      color: #fff;
      letter-spacing: 1.1px;
      transition: color 0.3s ease;
    }
    nav.navbar-custom .navbar-brand:hover {
      color: #ffd166;
    }
    nav.navbar-custom .nav-link {
      color: #e0e0e0;
      font-weight: 600;
      padding: 0.6rem 1rem;
      transition: color 0.3s ease;
      letter-spacing: 0.8px;
      font-size: 1rem;
    }
    nav.navbar-custom .nav-link:hover,
    nav.navbar-custom .nav-link:focus {
      color: #ffd166;
      text-shadow: 0 0 6px rgba(255, 209, 102, 0.9);
    }
        /* HERO con imagen de fondo responsiva y overlay */
        .hero-section {
            position: relative;
            height: 70vh;
            min-height: 350px;
            background: url('/img/imagen.png') no-repeat center center / cover;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            color: #fff;
            text-align: center;
            overflow: hidden;
        }

        /* Overlay oscuro para mejorar legibilidad */
        .hero-section::before {
            content: "";
            position: absolute;
            inset: 0; /* top:0; left:0; right:0; bottom:0; */
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        /* Contenido sobre el overlay */
        .hero-content {
            position: relative;
            max-width: 800px;
            z-index: 2;
            animation: fadeInUp 1.6s ease;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            text-shadow: 0 2px 10px rgba(0,0,0,0.7);
            margin-bottom: 0.5rem;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2.5vw, 1.4rem);
            font-weight: 300;
            margin-bottom: 1.5rem;
            text-shadow: 0 1px 6px rgba(0,0,0,0.6);
        }

        .hero-content .btn {
            background-color: #ffd166;
            color: #1a1a1a;
            font-weight: 700;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            box-shadow: 0 6px 12px rgb(255 209 102 / 0.5);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 1.1rem;
        }

        .hero-content .btn:hover {
            background-color: #f2c94c;
            box-shadow: 0 8px 18px rgb(242 201 76 / 0.7);
            color: #1a1a1a;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        
    /* --- FOOTER --- */
    footer.footer-custom {
      background: #007b83;
      color: #f1f1f1;
      padding: 3rem 2rem 2rem;
      margin-top: auto;
      font-size: 0.9rem;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
    }
    footer.footer-custom a {
      color: #ffd166;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    footer.footer-custom a:hover {
      color: #fff;
      text-decoration: underline;
    }
    footer.footer-custom .footer-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      max-width: 1100px;
      margin: 0 auto;
      gap: 2rem;
    }
    footer.footer-custom .footer-col {
      flex: 1 1 200px;
    }
    footer.footer-custom .footer-col h5 {
      margin-bottom: 1rem;
      font-weight: 700;
      letter-spacing: 1.1px;
      color: #ffd166;
    }
    footer.footer-custom .social-icons a {
      font-size: 1.4rem;
      margin-right: 1rem;
      color: #ffd166;
      transition: color 0.3s ease;
    }
    footer.footer-custom .social-icons a:hover {
      color: #fff;
    }
    footer.footer-custom small {
      display: block;
      margin-top: 2rem;
      color: #d1d1d1;
      text-align: center;
      font-weight: 400;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.8rem;
      }
      .hero-subtitle {
        font-size: 1.1rem;
      }
      footer.footer-custom .footer-container {
        flex-direction: column;
        gap: 1.5rem;
      }
    }
  </style>

    @stack('styles')
</head>
<body>
    <!-- NAV -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-globe-americas me-2"></i> SIG
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-2 fa-lg"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-1"></i> Perfil</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-section" role="img" aria-label="Vista panorámica del mapa con zonas de riesgo y seguras">
        <div class="hero-content">
            <h1 class="hero-title">Sistema de Información Geográfica</h1>
            <p class="hero-subtitle">Visualiza, gestiona y analiza zonas de riesgo, seguridad y puntos de encuentro.</p>
            <a href="{{ route('mapa.general') }}" class="btn btn-lg shadow">
                <i class="fas fa-map me-2"></i> Ver Mapa General
            </a>
        </div>
    </section>

    <!-- CONTENIDO -->
    <main class="container py-4">
        @yield('contenido')
    </main>

  <!-- FOOTER -->
  <footer class="footer-custom" role="contentinfo">
    <div class="footer-container">
      <div class="footer-col">
        <h5>Enlaces rápidos</h5>
        <ul class="list-unstyled">
          <li><a href="{{ url('/') }}">Inicio</a></li>
          <li><a href="{{ route('zonasriesgo.index') }}">Zonas Riesgo</a></li>
          <li><a href="{{ route('zonasegs.index') }}">Zonas Seguras</a></li>
          <li><a href="{{ route('puntos.index') }}">Puntos</a></li>
          <li><a href="{{ route('mapa.general') }}">Mapa</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Contacto</h5>
        <address>
          <p>
            <i class="fas fa-map-marker-alt me-2"></i> Ciudad, País<br />
            <i class="fas fa-phone me-2"></i> +593 123 456 789<br />
            <i class="fas fa-envelope me-2"></i>
            <a href="mailto:contacto@sig.com">contacto@sig.com</a>
          </p>
        </address>
        <div class="social-icons mt-3">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h5>Desarrolladores</h5>
        <p>Diego & Anthony</p>
      </div>
    </div>
    <small>© 2025 Sistema SIG | Todos los derechos reservados.</small>
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
