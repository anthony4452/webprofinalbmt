<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Puntos de Encuentro Comunitarios</h2>
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('puntos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Nuevo Punto de Encuentro
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 rounded">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Capacidad</th>
                        <th class="px-4 py-2 text-left">Responsable</th>
                        <th class="px-4 py-2 text-left">Ubicación</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($puntos as $punto)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $punto->nombre }}</td>
                            <td class="px-4 py-2">{{ $punto->capacidad }}</td>
                            <td class="px-4 py-2">{{ $punto->responsable }}</td>
                            <td class="px-4 py-2">
                                Lat: {{ $punto->latitud }}<br>
                                Long: {{ $punto->longitud }}
                            </td>
                            <td class="px-4 py-2">
                                @if($punto->activo)
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-sm">Activo</span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-sm">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('puntos.edit', $punto->id) }}"
                                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded mr-2 shadow">
                                    Editar
                                </a>

                                <form action="{{ route('puntos.destroy', $punto->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este punto?')">
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
                            <td colspan="6" class="text-center py-4 text-gray-600">No hay puntos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
