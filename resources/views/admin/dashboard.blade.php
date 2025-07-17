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

        <hr class="my-4">

        <a href="{{ route('puntos.index') }}" class="btn btn-primary">
            Gestionar Puntos de Encuentro Comunitarios
        </a>

        <hr class="my-4">

        <a href="{{ route('mapa.general') }}" class="btn btn-primary">
            Mapa General
        </a>
    </div>
</x-app-layout>

