<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Zonas de Riesgo</h2>
    </x-slot>

    <div class="container mx-auto p-6">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <a href="{{ route('zonasriesgo.create') }}" class="btn btn-primary mb-3">+ Nueva Zona de Riesgo</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Nivel de Riesgo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($zonas as $zona)
                    <tr>
                        <td>{{ $zona->nombre }}</td>
                        <td>{{ ucfirst($zona->nivel_riesgo) }}</td>
                        <td>{{ $zona->descripcion }}</td>
                        <td>
                            <a href="{{ route('zonasriesgo.edit', $zona->id) }}" class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('zonasriesgo.destroy', $zona->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta zona?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($zonas->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No hay zonas registradas.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</x-app-layout>
