<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeverancierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin-only user management routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Leverancier routes (Jamin warehouse management)
    Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
    Route::get('/leveranciers/{id}/producten', [LeverancierController::class, 'showProducten'])->name('leveranciers.producten');
    Route::get('/leveranciers/{leverancierId}/producten/{productId}/levering', [LeverancierController::class, 'createLevering'])->name('leveranciers.levering.create');
    Route::post('/leveranciers/{leverancierId}/producten/{productId}/levering', [LeverancierController::class, 'storeLevering'])->name('leveranciers.levering.store');
});

require __DIR__.'/auth.php';
