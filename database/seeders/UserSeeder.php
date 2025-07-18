<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'Usuario Normal',
                'email' => 'user@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]);
        }
    }
}
