<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Crear Usuario</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div>
                <label>Nombre</label>
                <input type="text" name="name" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Contraseña</label>
                <input type="password" name="password" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Rol</label>
                <select name="role" class="border p-2 w-full">
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
