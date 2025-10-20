<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicioPublicController;
use App\Http\Controllers\Admin\ServicioAdminController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CitaAdminController;

Route::get('/', fn () => redirect()->route('login'));

// Router de dashboard: si es admin => panel admin; si no => panel cliente
Route::get('/dashboard', function () {
    $user = auth()->user();
    return $user->admin
        ? redirect()->route('admin.dashboard')
        : app(ClientDashboardController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');

// Vista pública de servicios
Route::get('/servicios', [ServicioPublicController::class, 'index'])->name('servicios.index');

// Rutas del ADMIN
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin (vista + datos)
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // CRUD de servicios (admin)
        Route::resource('servicios', ServicioAdminController::class)->except(['show']);
          Route::patch('/citas/{cita}/cancelar', [CitaAdminController::class, 'cancel'])
              ->name('citas.cancel');
    });


// Rutas autenticadas (cliente)
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Citas (cliente)
    Route::get('/citas/reservar', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/mis-citas', [CitaController::class, 'index'])->name('citas.index');
});

require __DIR__ . '/auth.php';
