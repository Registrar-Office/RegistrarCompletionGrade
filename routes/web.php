<?php

use App\Http\Controllers\IncompleteGradeController;
use App\Http\Controllers\ProfileController;
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
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Incomplete Grades Routes
    Route::get('/incomplete-grades', [IncompleteGradeController::class, 'index'])->name('incomplete-grades.index');
    Route::get('/incomplete-grades/create', [IncompleteGradeController::class, 'create'])->name('incomplete-grades.create');
    Route::post('/incomplete-grades', [IncompleteGradeController::class, 'store'])->name('incomplete-grades.store');
    Route::get('/incomplete-grades/{incompleteGrade}', [IncompleteGradeController::class, 'show'])->name('incomplete-grades.show');
    Route::get('/incomplete-grades/{incompleteGrade}/edit', [IncompleteGradeController::class, 'edit'])->name('incomplete-grades.edit');
    Route::put('/incomplete-grades/{incompleteGrade}', [IncompleteGradeController::class, 'update'])->name('incomplete-grades.update');
    Route::delete('/incomplete-grades/{incompleteGrade}', [IncompleteGradeController::class, 'destroy'])->name('incomplete-grades.destroy');
    Route::patch('/incomplete-grades/{incompleteGrade}/status', [IncompleteGradeController::class, 'updateStatus'])->name('incomplete-grades.update-status');
});

require __DIR__.'/auth.php';
