<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/municipios/by/provincia', [\App\Http\Controllers\URLController::class, 'municipios_by_provincias']);

    Route::resource('tipologias', \App\Http\Controllers\TipologiaController::class);
    Route::resource('property-types', \App\Http\Controllers\PropertyTypeController::class);
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
    Route::resource('imoveis', \App\Http\Controllers\ImovelController::class);
});

require __DIR__ . '/auth.php';
