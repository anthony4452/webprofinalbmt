<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Editar Zona de Riesgo</h2>
    </x-slot>

    <div class="container mx-auto p-6">
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Corrige los siguientes errores:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('zonasriesgo.update', $zonasriesgo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $zonasriesgo->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $zonasriesgo->descripcion) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="nivel_riesgo" class="form-label">Nivel de Riesgo *</label>
                <select name="nivel_riesgo" id="nivel_riesgo" class="form-select" required>
                    <option value="bajo" {{ old('nivel_riesgo', $zonasriesgo->nivel_riesgo) == 'bajo' ? 'selected' : '' }}>Bajo</option>
                    <option value="medio" {{ old('nivel_riesgo', $zonasriesgo->nivel_riesgo) == 'medio' ? 'selected' : '' }}>Medio</option>
                    <option value="alto" {{ old('nivel_riesgo', $zonasriesgo->nivel_riesgo) == 'alto' ? 'selected' : '' }}>Alto</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="coordenadas" class="form-label">Coordenadas *</label>
                <textarea name="coordenadas" id="coordenadas" class="form-control" rows="4" required>{{ old('coordenadas', $zonasriesgo->coordenadas) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('zonasriesgo.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Zona</button>
            </div>
        </form>
    </div>
</x-app-layout>
