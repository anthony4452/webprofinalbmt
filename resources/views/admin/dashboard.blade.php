<x-app-layout>
    <x-slot name="header">
        <h2>Panel de Administrador</h2>
    </x-slot>

    <div class="p-6">
        <p>Bienvenido Admin {{ auth()->user()->name }}</p>

        <hr class="my-4">

        <a href="{{ route('zonasriesgo.index') }}" class="btn btn-primary">
            Gestionar Zonas de Riesgo
        </a>
    </div>
</x-app-layout>

