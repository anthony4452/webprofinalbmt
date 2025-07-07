<x-app-layout>
    <x-slot name="header">
        <h2>Panel de Usuario</h2>
    </x-slot>

    <div class="p-6">
        <p>Bienvenido Usuario {{ auth()->user()->name }}</p>
    </div>
</x-app-layout>
