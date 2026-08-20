<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CareerPathController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\ExportController;

// 1. Root redirection
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Guest-only routes (Auth)
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// 3. Authenticated routes (Common)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// 4. Admin-only routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/students', [AdminDashboardController::class, 'students'])->name('students');
    Route::get('/students/{id}/results', [AdminDashboardController::class, 'studentResults'])->name('students.results');
    Route::delete('/students/{id}', [AdminDashboardController::class, 'deleteStudent'])->name('students.destroy');

    // Resources
    Route::resource('sessions', SessionController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('careers', CareerPathController::class);

    // Exports
    Route::get('/exports/students/csv', [ExportController::class, 'exportStudentsCsv'])->name('exports.students.csv');
});

// 5. Student-only routes
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/session/join', [StudentDashboardController::class, 'showJoinSession'])->name('session.join');
    Route::post('/session/join', [StudentDashboardController::class, 'joinSession'])->name('session.submit');
    
    // Assessment routes
    Route::get('/assessment', [StudentDashboardController::class, 'showAssessment'])->name('assessment');
    Route::post('/assessment/save', [StudentDashboardController::class, 'saveAnswer'])->name('assessment.save');
    Route::post('/assessment/complete', [StudentDashboardController::class, 'completeAssessment'])->name('assessment.complete');
    
    // Results
Route::get('/results', [StudentDashboardController::class, 'showResults'])->name('results');
Route::get('/results/report', [ExportController::class, 'downloadReport'])->name('results.report');

// Review / Thank You
Route::get('/review', function () {
    return view('review');
})->name('review');

    
});

