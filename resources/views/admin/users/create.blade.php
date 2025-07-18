@extends('layouts.app')

@section('contenido')
<div class="container py-4" style="min-height: 80vh;">
    <h2 class="text-2xl font-bold mb-6 text-dark">Crear Usuario</h2>

    <div class="p-6 max-w-md mx-auto bg-white rounded shadow">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block font-semibold mb-2">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-style" required>
            </div>

            <div>
                <label class="block font-semibold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input-style" required>
            </div>

            <div>
                <label class="block font-semibold mb-2">Contraseña</label>
                <input type="password" name="password" class="input-style" required>
            </div>

            <div>
                <label class="block font-semibold mb-2">Rol</label>
                <select name="role" class="input-style">
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Regresar</a>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .input-style {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1.5px solid #a8dadc;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }
    .input-style:focus {
        border-color: #007b83;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 131, 0.5);
    }
    .btn-primary {
        background-color: #007b83;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #005f62;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        border: none;
        transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        color: white;
        text-decoration: none;
    }
</style>
@endpush
@endsection
