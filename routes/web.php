<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

// Publieke routes
Route::get('/', function () {
    return view('welcome');
});

// Geregistreerde gebruiker dashboard route
Route::get('/dashboard', [FileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::post('/files/upload', [FileController::class, 'store'])->name('files.upload');
    Route::get('/files/download/{id}', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/delete/{id}', [FileController::class, 'destroy'])->name('files.delete');
    Route::post('/share', [FileController::class, 'share'])->name('files.share');
    Route::get('/shared-with-me', [FileController::class, 'sharedWithMe'])->name('files.shared');
    Route::get('/shared/download/{id}', [FileController::class, 'downloadSharedFile'])->name('files.shared.download');


});

require __DIR__.'/auth.php';

