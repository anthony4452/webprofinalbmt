@extends('layouts.app')

@section('contenido')
<div class="container py-4" style="min-height: 80vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="text-light d-flex align-items-center gap-2">
            <i class="fas fa-map-marker-alt fa-2x text-primary"></i> Puntos de Encuentro Comunitarios
        </h2>
        <a href="{{ route('puntos.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Punto de Encuentro
        </a>
    </div>

    <div class="table-responsive shadow rounded">
        <table id="puntosTable" class="table table-striped table-bordered align-middle" style="background: white;">
            <thead class="table-header-blue">
                <tr>
                    <th>Nombre</th>
                    <th>Capacidad</th>
                    <th>Responsable</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th style="width: 160px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($puntos as $punto)
                <tr>
                    <td>{{ $punto->nombre }}</td>
                    <td>{{ $punto->capacidad }}</td>
                    <td>{{ $punto->responsable }}</td>
                    <td>
                        Lat: {{ $punto->latitud }}<br>
                        Long: {{ $punto->longitud }}
                    </td>
                    <td>
                        @if($punto->activo)
                            <span class="badge bg-success text-white">Activo</span>
                        @else
                            <span class="badge bg-danger text-white">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('puntos.edit', $punto->id) }}" class="btn btn-warning btn-sm me-1" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('puntos.destroy', $punto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este punto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #f1fcfc);
        color: #000;
    }

    h2.text-light {
        color: #000 !important;
    }

    .table-header-blue th {
        background-color: #a8dadc;
        color: #000;
        border-color: #a8dadc;
    }

    .table {
        background-color: #fff;
        color: #000;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        background-color: #fff !important;
        border: 1px solid #a8dadc !important;
        color: #000 !important;
        border-radius: 4px;
        padding: 4px 8px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #000 !important;
        background: transparent !important;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #a8dadc !important;
        color: #000 !important;
        border-radius: 4px;
    }

    .btn-success {
        background-color: #007b83;
        border-color: #007b83;
    }

    .btn-success:hover {
        background-color: #005f62;
        border-color: #005f62;
    }

    .btn-warning {
        background-color: #facc15;
        border-color: #facc15;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #b45309;
        border-color: #b45309;
        color: #fff;
    }

    .btn-danger {
        background-color: #dc2626;
        border-color: #dc2626;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #991b1b;
        border-color: #991b1b;
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#puntosTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            responsive: true,
        });
    });
</script>
@endpush
