<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Applicant routes
Route::middleware(['auth', 'verified', 'role:volunteer'])->group(function () {
    Route::get('/applicant/home', [ApplicantController::class, 'index'])->name('applicant.home');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:expert'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');
});

// Manager routes
Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    Route::get('/manager/home', [ManagerController::class, 'index'])->name('manager.home');
});

require __DIR__.'/auth.php';
