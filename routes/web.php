<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ConocimientoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de SaberTech
|--------------------------------------------------------------------------
| Todas las páginas internas exigen sesión iniciada (middleware auth).
*/

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // create, store, show, edit, update, destroy
    Route::resource('conocimientos', ConocimientoController::class)->except('index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
| Panel de administración: solo usuarios con is_admin = true (middleware admin).
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\PanelController::class, 'index'])->name('panel');

    Route::resource('conocimientos', Admin\ConocimientoController::class)->except('show');
    Route::resource('categorias', Admin\CategoriaController::class)->except('show')
        ->parameters(['categorias' => 'categoria']);
    Route::resource('usuarios', Admin\UserController::class)->only(['index', 'edit', 'update', 'destroy'])
        ->parameters(['usuarios' => 'user']);
});

require __DIR__.'/auth.php';
