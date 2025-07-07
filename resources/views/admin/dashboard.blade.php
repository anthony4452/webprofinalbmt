<x-app-layout>
    <x-slot name="header">
        <h2>Panel de Administrador</h2>
    </x-slot>

    <div class="p-6">
        <p>Bienvenido Admin {{ auth()->user()->name }}</p>
    </div>
</x-app-layout>
