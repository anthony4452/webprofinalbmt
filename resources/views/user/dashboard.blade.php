@extends('layouts.app')

@section('contenido')

@push('styles')
<style>
    .dashboard-grid {
        display: flex;
        gap: 2rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    .dashboard-box {
        background-color: #007b83;
        color: white;
        border-radius: 15px;
        padding: 3rem 2.5rem;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 6px 15px rgba(0, 123, 131, 0.4);
        transition: all 0.3s ease;
        min-width: 240px;
        flex: 1 1 240px;
        user-select: none;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .dashboard-box:hover {
        background-color: #005f66;
        box-shadow: 0 10px 25px rgba(0, 95, 102, 0.7);
        color: white;
        text-decoration: none;
    }
    .dashboard-box i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        display: block;
    }
    .dashboard-box h5 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    /* Botón reportes abajo */
    .report-button-container {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }
    .report-button {
        background-color: #d97706; /* color ámbar/amarillo */
        border: none;
        border-radius: 15px;
        padding: 1rem 3rem;
        font-size: 1.3rem;
        font-weight: 700;
        color: white;
        cursor: pointer;
        box-shadow: 0 6px 15px rgba(217, 119, 6, 0.5);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .report-button:hover {
        background-color: #b45309;
        box-shadow: 0 10px 25px rgba(180, 83, 9, 0.7);
    }
    .report-button i {
        font-size: 1.8rem;
    }
</style>
@endpush

<div class="container py-4 text-center">
    <h1 class="mb-4">Panel de Usuario</h1>
    <p>Bienvenido, <strong>{{ auth()->user()->name }}</strong></p>

    <div class="dashboard-grid">
        <a href="{{ route('mapa.general') }}" class="dashboard-box" aria-label="Mapa General">
            <i class="fas fa-map"></i>
            <h5>Mapa General</h5>
            <p>Visualizar zonas en el mapa</p>
        </a>
    </div>

    <div class="report-button-container">
        <form method="POST" action="{{ route('reportes.generar') }}">
            @csrf
            <button type="submit" class="report-button" aria-label="Generar Reportes">
                <i class="fas fa-file-alt"></i> Generar Reportes
            </button>
        </form>
    </div>
</div>

@endsection
