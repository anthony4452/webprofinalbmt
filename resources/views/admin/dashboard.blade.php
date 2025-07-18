@extends('layouts.app')

@section('contenido')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .card-summary {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 15px;
        color: white;
    }

    .dashboard-box {
        background-color: rgba(255, 255, 255, 0.08);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease-in-out;
        color: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .dashboard-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .dashboard-box i {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 30px;
    }

    #miniMapa {
        height: 300px;
        border-radius: 15px;
    }

    .bg-sig {
        background: linear-gradient(to right, #667eea, #764ba2);
    }
</style>
@endpush

<div class="container py-4 text-white">

<div class="text-center mb-5" style="color: black;">
    <h1 class="display-5 fw-bold" data-aos="fade-down">
        <i class="fas fa-tools me-2"></i>Panel del Administrador
    </h1>
    <p class="fs-5">Bienvenido {{ auth()->user()->name }} 👋</p>
</div>


    <!-- Tarjetas resumen -->
    <div class="row text-white mb-5" data-aos="fade-up">
        <div class="col-md-3 mb-3">
            <div class="card card-summary shadow p-3 text-center bg-danger">
                <h4><i class="fas fa-exclamation-triangle"></i> {{ $totalZonasRiesgo }}</h4>
                <p>Zonas de Riesgo</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-summary shadow p-3 text-center bg-success">
                <h4><i class="fas fa-shield-alt"></i> {{ $totalZonasSeguras }}</h4>
                <p>Zonas Seguras</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-summary shadow p-3 text-center bg-warning">
                <h4><i class="fas fa-map-marker-alt"></i> {{ $totalPuntos }}</h4>
                <p>Puntos de Encuentro</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-summary shadow p-3 text-center bg-info">
                <h4><i class="fas fa-users"></i> {{ $totalUsuarios }}</h4>
                <p>Usuarios</p>
            </div>
        </div>
    </div>

    <!-- Botones principales -->
    <div class="dashboard-grid mb-5" data-aos="fade-up" data-aos-delay="200">

        <a href="{{ route('zonasriesgo.index') }}" class="text-decoration-none">
            <div class="dashboard-box bg-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <h5>Zonas de Riesgo</h5>
                <p>Administrar zonas vulnerables</p>
            </div>
        </a>

        <a href="{{ route('zonasegs.index') }}" class="text-decoration-none">
            <div class="dashboard-box bg-success">
                <i class="fas fa-shield-alt"></i>
                <h5>Zonas Seguras</h5>
                <p>Definir lugares protegidos</p>
            </div>
        </a>

        <a href="{{ route('puntos.index') }}" class="text-decoration-none">
            <div class="dashboard-box bg-warning">
                <i class="fas fa-map-marker-alt"></i>
                <h5>Puntos de Encuentro</h5>
                <p>Gestionar puntos comunitarios</p>
            </div>
        </a>

        <a href="{{ route('mapa.general') }}" class="text-decoration-none">
            <div class="dashboard-box bg-info">
                <i class="fas fa-map"></i>
                <h5>Mapa General</h5>
                <p>Visualizar zonas en el mapa</p>
            </div>
        </a>

        <form method="POST" action="{{ route('reportes.generar') }}">
            @csrf
            <button type="submit" class="btn btn-warning text-decoration-none">
                <div class="dashboard-box bg-warning">
                    <i class="fas fa-file"></i>
                    <h5>Reportes</h5>
                    <p>Realizar Reportes</p>
                </div>
            </button>
        </form>



        <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
            <div class="dashboard-box bg-success">
                <i class="fas fa-user"></i>
                <h5>Usuarios</h5>
                <p>Gestión de Usuarios Regsitrados</p>
            </div>
        </a>

    </div>

    <!-- Mini mapa -->
    <div class="card bg-light shadow mb-5" data-aos="fade-up" data-aos-delay="400">
        <div class="card-body">
            <h5 class="card-title text-dark"><i class="fas fa-map"></i> Vista rápida del mapa</h5>
            <div id="miniMapa"></div>
        </div>
    </div>

    <!-- Últimos registros -->
    <div class="card shadow" data-aos="fade-up" data-aos-delay="500">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-clock"></i> Últimas Zonas de Riesgo</h5>
            <ul class="list-group list-group-flush">
                @forelse($ultimasZonas as $zona)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $zona->nombre }}
                        <small class="text-muted">{{ $zona->created_at->diffForHumans() }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No hay zonas registradas aún.</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>

<script>
    function initMiniMapa() {
        const centro = { lat: -0.933, lng: -78.617 };
        const map = new google.maps.Map(document.getElementById("miniMapa"), {
            center: centro,
            zoom: 13,
        });

        // marcador base
        new google.maps.Marker({
            position: centro,
            map: map,
            title: "Zona central"
        });
    }

    // Cargar mapa
    window.initMap = initMiniMapa;
</script>
@endpush

@endsection
