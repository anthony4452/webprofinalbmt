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
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ReporteController;

// Alias para middlewares
Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
Route::aliasMiddleware('user', \App\Http\Middleware\UserMiddleware::class);

// Ruta raíz
Route::get('/', fn () => redirect()->route('login'));

// Dashboard general
Route::get('/dashboard', function () {
    $user = Auth::user();
    return $user->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==============================
// RUTAS PARA ADMINISTRADORES
// ==============================
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Mantener rutas sin prefijo para que las vistas antiguas funcionen sin cambiar nada
    Route::resource('zonasriesgo', ZonaRiesgoController::class);
    Route::resource('puntos', PuntosController::class);
    Route::resource('zonasegs', ZonaSegController::class);
    
    // Esta sí puede mantener el prefijo
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserManagementController::class);
    });
});

// ==============================
// RUTAS PARA USUARIOS
// ==============================
Route::middleware(['auth', 'verified', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
});

// ==============================
// RUTAS COMPARTIDAS
// ==============================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mapa-general', [MapaController::class, 'index'])->name('mapa.general');
    Route::get('/reporte/zonas', [ReporteController::class, 'exportarZonasPDF'])->name('reporte.zonas');
});

// ==============================
// PERFIL
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// AUTENTICACIÓN
// ==============================
require __DIR__.'/auth.php';
