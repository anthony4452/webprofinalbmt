<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZonaRiesgoController;
use App\Http\Controllers\PuntosController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\ZonaSegController;

// Registrar middleware alias directamente para que Laravel los reconozca
Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
Route::aliasMiddleware('user', \App\Http\Middleware\UserMiddleware::class);

// Ruta raíz que redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Ruta dashboard que redirige según rol
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para administradores con middleware admin
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('zonasriesgo', ZonaRiesgoController::class);
    Route::resource('puntos', PuntosController::class);
    Route::get('/mapa-general', [MapaController::class, 'index'])->name('mapa.general');
    Route::resource('zonasegs', ZonaSegController::class);
    Route::resource('/admin/users', UserController::class);



    



});

// Rutas para usuarios comunes con middleware user
Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// Rutas para perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación generadas por Breeze (u otro paquete)
require __DIR__.'/auth.php';
