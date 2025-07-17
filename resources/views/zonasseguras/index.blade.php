<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Zonas Seguras</h2>
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('zonasseguras.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Nueva Zona Segura
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 rounded">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Radio (m)</th>
                        <th class="px-4 py-2 text-left">Tipo de Seguridad</th>
                        <th class="px-4 py-2 text-left">Ubicación (Lat, Long)</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zonasSeguras as $zona)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $zona->nombre }}</td>
                            <td class="px-4 py-2">{{ $zona->radio }}</td>
                            <td class="px-4 py-2">{{ $zona->tipo_seguridad }}</td>
                            <td class="px-4 py-2">{{ $zona->latitud }}, {{ $zona->longitud }}</td>
                            <td class="px-4 py-2">
                                @if($zona->activo)
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-sm">Activo</span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-sm">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('zonasseguras.edit', $zona->id) }}"
                                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded mr-2 shadow">
                                    Editar
                                </a>

                                <form action="{{ route('zonasseguras.destroy', $zona->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta zona segura?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded shadow">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-600">No hay zonas seguras registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
