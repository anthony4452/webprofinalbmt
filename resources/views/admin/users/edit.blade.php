<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Editar Usuario</h2>
    </x-slot>

    <div class="p-6 max-w-md mx-auto bg-white rounded shadow">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
            @csrf 
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1">Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" class="border p-2 w-full rounded" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="border p-2 w-full rounded" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Rol</label>
                <select name="role" class="border p-2 w-full rounded">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
            <br>
            <div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">

                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
