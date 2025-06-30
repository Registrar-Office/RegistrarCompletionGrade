<?php

use App\Http\Controllers\DeanDashboardController;
use App\Http\Controllers\IncompleteGradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RulesController;
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
    
    // Rules and Guidelines route - accessible to all authenticated users
    Route::get('/rules', [RulesController::class, 'index'])->name('rules.index');
    
    // Incomplete grades resource routes
    Route::resource('incomplete-grades', IncompleteGradeController::class);
    
    // Dean Dashboard Routes - use both auth and dean middleware
    Route::middleware([\App\Http\Middleware\DeanOnlyMiddleware::class])->prefix('dean')->group(function () {
        Route::get('/dashboard', [DeanDashboardController::class, 'index'])->name('dean.dashboard');
        Route::get('/signature', [DeanDashboardController::class, 'manageSignature'])->name('dean.signature');
        Route::post('/signature', [DeanDashboardController::class, 'storeSignature'])->name('dean.signature.store');
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
        Route::get('/courses/{course}/grade-checklist', [\App\Http\Controllers\FacultyDashboardController::class, 'gradeChecklist'])->name('faculty.grade-checklist');
        Route::post('/courses/{course}/grade-checklist/{student}', [\App\Http\Controllers\FacultyDashboardController::class, 'updateGradeChecklist'])->name('faculty.grade-checklist.update');
    });
    
    // Allow students to view their approval documents
    Route::get('/approval-documents/{incompleteGrade}', [IncompleteGradeController::class, 'viewApprovalDocument'])
        ->middleware('can:view,incompleteGrade')
        ->name('incomplete-grades.approval-document');

    // Announcement routes
    Route::resource('announcement', AnnouncementController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // Student Grade Checklist View
    Route::middleware('auth')->get('/profile/grade-checklist', [\App\Http\Controllers\ProfileController::class, 'gradeChecklist'])->name('profile.grade-checklist');
    
    // Student Curriculum View
    Route::middleware('auth')->get('/profile/curriculum', [\App\Http\Controllers\ProfileController::class, 'curriculum'])->name('profile.curriculum');
});

require __DIR__.'/auth.php';
