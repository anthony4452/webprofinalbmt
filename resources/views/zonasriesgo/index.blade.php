@extends('layouts.app')

@section('contenido')
<div class="container py-4" style="min-height: 80vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="text-light d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i> Zonas de Riesgo
        </h2>
        <a href="{{ route('zonasriesgo.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nueva Zona de Riesgo
        </a>
    </div>

    <div class="table-responsive shadow rounded">
        <table id="zonasTable" class="table table-striped table-bordered align-middle" style="background: white;">
            <thead class="table-header-blue">
                <tr>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Descripción</th>
                    <th style="width: 160px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($zonas as $zona)
                <tr>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ ucfirst($zona->nivel_riesgo) }}</td>
                    <td>{{ $zona->descripcion }}</td>
                    <td>
                        <a href="{{ route('zonasriesgo.edit', $zona->id) }}" class="btn btn-warning btn-sm me-1" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('zonasriesgo.destroy', $zona->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta zona?')">
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
@push('styles')
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #f1fcfc); /* fondo celeste pastel */
        color: #000; /* texto negro */
    }

    h2.text-light {
        color: #000 !important;
    }

    .table-header-blue th {
        background-color: #a8dadc; /* celeste pastel */
        color: #000; /* texto negro */
        border-color: #a8dadc;
    }

    .table {
        background-color: #ffffff;
        color: #000;
    }

    /* Ajustes DataTables para inputs y selects */
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        background-color: #ffffff !important;
        border: 1px solid #a8dadc !important;
        color: #000 !important;
        border-radius: 4px;
        padding: 4px 8px;
    }

    /* Paginación */
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

    /* Botones de acción */
    .btn-success {
        background-color: #007b83;
        border-color: #007b83;
    }

    .btn-success:hover {
        background-color: #005f62;
        border-color: #005f62;
    }

</style>
@endpush

@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#zonasTable').DataTable({
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