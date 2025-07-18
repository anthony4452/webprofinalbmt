@extends('layouts.app')

@section('contenido')
<div class="container py-4" style="min-height: 80vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="text-dark d-flex align-items-center gap-2">
            <i class="fas fa-shield-alt fa-2x text-success"></i> Zonas Seguras
        </h2>
        <a href="{{ route('zonasegs.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nueva Zona Segura
        </a>
    </div>

    <div class="table-responsive shadow rounded">
        <table id="zonasSegurasTable" class="table table-striped table-bordered align-middle" style="background: white;">
            <thead class="table-header-green">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Radio (m)</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($zonasegs as $zona)
                <tr>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ $zona->tipo_seguridad }}</td>
                    <td>{{ $zona->radio }}</td>
                    <td>
                        Lat: {{ $zona->latitud }}<br>
                        Long: {{ $zona->longitud }}
                    </td>
                    <td>
                        @if($zona->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('zonasegs.edit', $zona->id) }}" class="btn btn-warning btn-sm me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('zonasegs.destroy', $zona->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta zona segura?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No hay zonas seguras registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #f1fcfc); /* fondo celeste pastel */
        color: #000;
    }

    h2.text-dark {
        color: #000 !important;
    }

    .table-header-green th {
        background-color: #b2f2bb; /* verde pastel */
        color: #000;
        border-color: #b2f2bb;
    }

    .table {
        background-color: #ffffff;
        color: #000;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        background-color: #ffffff !important;
        border: 1px solid #b2f2bb !important;
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
        background-color: #69db7c !important;
        color: #000 !important;
        border-radius: 4px;
    }

    .btn-success {
        background-color: #38b000;
        border-color: #38b000;
    }

    .btn-success:hover {
        background-color: #2a8800;
        border-color: #2a8800;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#zonasSegurasTable').DataTable({
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
