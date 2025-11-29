<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProfileController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Login Required)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Toggle checkbox done/undone
    Route::post('/tugas/{id}/toggle-done', [DashboardController::class, 'toggleDone'])->name('tugas.toggle-done');
    
    // CRUD Tugas Routes
    Route::get('/tugas/create', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/tugas/{id}', [TugasController::class, 'show'])->name('tugas.show');
    Route::get('/tugas/{id}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');
    
    //Status Dropdown
    Route::post('/tugas/{id}/update-status', [TugasController::class, 'updateStatus'])->name('tugas.updateStatus');
    
    // Mata kuliah Routes
    Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])->name('mata-kuliah.store');
    
    Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('mata-kuliah.index');
    Route::get('/mata-kuliah/{id}/edit', [MataKuliahController::class, 'edit'])->name('mata-kuliah.edit');
    Route::put('/mata-kuliah/{id}', [MataKuliahController::class, 'update'])->name('mata-kuliah.update');
    Route::delete('/mata-kuliah/{id}', [MataKuliahController::class, 'destroy'])->name('mata-kuliah.destroy');

    Route::get('/mata-kuliah/create', function () {
        return view('mata-kuliah.index'); // atau halaman khusus create
    })->name('mata-kuliah.create');


   // Profile menu
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Update profil (nama & email)
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Change password
    Route::get('/change-password', [ProfileController::class, 'editPassword'])->name('password.change');
    Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('password.update');

});