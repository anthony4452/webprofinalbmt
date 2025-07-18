<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Editar Usuario</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div>
                <label>Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Rol</label>
                <select name="role" class="border p-2 w-full">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
