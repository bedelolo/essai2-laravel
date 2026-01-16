<?php

use App\Http\Controllers\ProfileController;
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

    // Routes pour les demandes (Utilisateur)
    Route::post('/demandes/autosave', [\App\Http\Controllers\DemandeController::class, 'autosave'])->name('demandes.autosave');
    Route::get('/demandes/export-pdf', [\App\Http\Controllers\DemandeController::class, 'exportPdf'])->name('demandes.export');
    Route::resource('demandes', \App\Http\Controllers\DemandeController::class);

    // Routes pour l'administrateur
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pending', [\App\Http\Controllers\AdminController::class, 'demandesEnAttente'])->name('pending');
        Route::get('/history', [\App\Http\Controllers\AdminController::class, 'historique'])->name('history');
        Route::get('/export-pdf', [\App\Http\Controllers\AdminController::class, 'exportPdf'])->name('export');
        Route::patch('/demandes/{demande}/approve', [\App\Http\Controllers\AdminController::class, 'approuver'])->name('approve');
        Route::patch('/demandes/{demande}/reject', [\App\Http\Controllers\AdminController::class, 'rejeter'])->name('reject');
    });
});

require __DIR__.'/auth.php';
