<?php

use App\Http\Controllers\DeanDashboardController;
use App\Http\Controllers\IncompleteGradeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;

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
    
    // Dean Dashboard Routes - use both auth and dean middleware
    Route::middleware(['auth', 'dean'])->prefix('dean')->group(function () {
        Route::get('/dashboard', [DeanDashboardController::class, 'index'])->name('dean.dashboard');
        Route::get('/signature', [DeanDashboardController::class, 'manageSignature'])->name('dean.signature');
        Route::post('/signature', [DeanDashboardController::class, 'storeSignature'])->name('dean.store-signature');
        Route::get('/applications/{incompleteGrade}', [DeanDashboardController::class, 'show'])->name('dean.show');
        Route::get('/applications/{incompleteGrade}/approve', [DeanDashboardController::class, 'approve'])->name('dean.approve');
        Route::put('/applications/{incompleteGrade}/reject', [DeanDashboardController::class, 'reject'])->name('dean.reject');
        Route::post('/applications/bulk-approve', [DeanDashboardController::class, 'bulkApprove'])->name('dean.bulk-approve');
        Route::get('/applications/{incompleteGrade}/approval-document', [DeanDashboardController::class, 'approvalDocument'])->name('dean.approval-document');
    });

    // Faculty Dashboard Route - use both auth and faculty middleware
    Route::middleware(['auth', \App\Http\Middleware\FacultyOnlyMiddleware::class])->prefix('faculty')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\FacultyDashboardController::class, 'index'])->name('faculty.dashboard');
        Route::get('/applications/{incompleteGrade}', [\App\Http\Controllers\FacultyDashboardController::class, 'show'])->name('faculty.show');
        Route::put('/applications/{incompleteGrade}/reject', [\App\Http\Controllers\FacultyDashboardController::class, 'reject'])->name('faculty.reject');
        Route::post('/applications/{incompleteGrade}/forward', [\App\Http\Controllers\FacultyDashboardController::class, 'forward'])->name('faculty.forward');
    });
    
    // Allow students to view their approval documents
    Route::get('/approval-documents/{incompleteGrade}', [IncompleteGradeController::class, 'viewApprovalDocument'])
        ->middleware('can:view,incompleteGrade')
        ->name('incomplete-grades.approval-document');

    // Announcement routes
    Route::resource('announcement', AnnouncementController::class)->only(['index', 'create', 'store', 'edit', 'update']);
});

require __DIR__.'/auth.php';
