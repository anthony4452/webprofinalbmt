<x-app-layout>
    <x-slot name="header">
        <h2>Panel de Usuario</h2>
    </x-slot>

    <div class="p-6">
        <p>Bienvenido Usuario {{ auth()->user()->name }}</p>
    </div>

    <hr class="my-4">

    <a href="{{ route('mapa.general') }}" class="btn btn-primary">
            Mapa General
    </a>
</x-app-layout>
