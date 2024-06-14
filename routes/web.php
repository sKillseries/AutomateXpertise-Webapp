<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReconController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('/');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

# Section reconnaissance
Route::middleware('auth')->group(function () {
    Route::get('/recon', [ReconController::class, 'index'])->name('recon');
    Route::post('/execute-recon', [ReconController::class, 'executeScript']);
});

# Section scanning
Route::middleware('auth')->group(function () {
    Route::get('/scan', [ScanController::class, 'index'])->name('scan');
    Route::post('/execute-scan', [ScanController::class, 'executeScript']);
});

# Section resultats
Route:: middleware('auth')->group(function () {
    Route::get('/files', [FileController::class, 'showFiles'])->name('files');
    Route::get('/files/view/{filename}', [FileController::class, 'viewFile'])->name('view');
    Route::get('/files/download/{filename}', [FileController::class, 'download'])->name('download');
    Route::get('/files/markdown/{filename}', [FileController::class, 'markdown'])->name('markdown');
    Route::get('/files/pdf/{filename}', [FileController::class, 'pdf'])->name('pdf');
    Route::get('/files/word/{filename}', [FileController::class, 'word'])->name('word');
});

require __DIR__.'/auth.php';
