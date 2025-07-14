<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Zonas de Riesgo</h2>
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if(session('message'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('zonasriesgo.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Nueva Zona de Riesgo
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 rounded">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Nivel de Riesgo</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zonas as $zona)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $zona->nombre }}</td>
                            <td class="px-4 py-2 capitalize">{{ $zona->nivel_riesgo }}</td>
                            <td class="px-4 py-2">{{ $zona->descripcion }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('zonasriesgo.edit', $zona->id) }}"
                                   class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded mr-2 shadow">
                                    Editar
                                </a>

                                <form action="{{ route('zonasriesgo.destroy', $zona->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta zona?')">
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
                            <td colspan="4" class="text-center py-4 text-gray-600">No hay zonas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
