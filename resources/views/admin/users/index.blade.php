@extends('layouts.app')

@section('contenido')
<div class="container py-4" style="min-height: 80vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="text-2xl font-bold text-dark d-flex align-items-center gap-2">
            <i class="fas fa-users-cog fa-2x text-primary"></i> Gestión de Usuarios
        </h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-user-plus me-1"></i> Nuevo Usuario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive shadow rounded">
        <table id="usersTable" class="table table-striped table-bordered align-middle" style="background: white;">
            <thead class="table-header-blue">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th style="width: 160px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-capitalize">{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm me-1" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">No hay usuarios registrados.</td>
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
        background: linear-gradient(to right, #e0f7fa, #f1fcfc);
        color: #000;
    }

    .table-header-blue th {
        background-color: #a8dadc !important;
        color: #000 !important;
        border-color: #a8dadc !important;
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
        $('#usersTable').DataTable({
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
