<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ApplicationController;


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

require __DIR__ . '/auth.php';



Route::middleware(['auth'])->group(function () {
    Route::get('/application/step0', [ApplicationController::class, 'step0'])->name('application.step0');
    Route::get('/application/step1', [ApplicationController::class, 'step1'])->name('application.step1');
    Route::post('/application/step1', [ApplicationController::class, 'storeStep1'])->name('application.storeStep1');

    Route::get('/application/step2', [ApplicationController::class, 'step2'])->name('application.step2');
    Route::post('/application/step2', [ApplicationController::class, 'storeStep2'])->name('application.storeStep2');

    Route::get('/application/step3', [ApplicationController::class, 'step3'])->name('application.step3');
    Route::post('/application/step3', [ApplicationController::class, 'storeStep3'])->name('application.storeStep3');

    Route::get('/application/step4', [ApplicationController::class, 'step4'])->name('application.step4');
    Route::post('/application/step4', [ApplicationController::class, 'storeStep4'])->name('application.storeStep4');

    Route::get('/application/step5', [ApplicationController::class, 'step5'])->name('application.step5');
    Route::post('/application/step5', [ApplicationController::class, 'storeStep5'])->name('application.storeStep5');

    Route::get('/application/step6', [ApplicationController::class, 'step6'])->name('application.step6');
    Route::post('/application/step6', [ApplicationController::class, 'storeStep6'])->name('application.storeStep6');
    Route::post('/application/step6/comment', [ApplicationController::class, 'storeComment'])->name('application.storeComment');


    Route::get('/application/step7', [ApplicationController::class, 'step7'])->name('application.step7');
    Route::post('/application/step7', [ApplicationController::class, 'storeStep7'])->name('application.storeStep7');
});
