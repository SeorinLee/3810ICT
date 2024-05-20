<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
<<<<<<< Updated upstream
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
=======
>>>>>>> Stashed changes
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Volunteer routes
Route::middleware(['auth', 'verified', 'role:volunteer'])->group(function () {
    Route::get('/volunteer/home', [VolunteerController::class, 'index'])->name('volunteer.home');
});

// Expert routes
Route::middleware(['auth', 'verified', 'role:expert'])->group(function () {
    Route::get('/expert/home', function () {
        return 'Expert home page';
    })->name('expert.home');
});

// Manager routes
Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    Route::get('/manager/home', function () {
        return 'Manager home page';
    })->name('manager.home');
});

Route::post('/volunteer/details/save', [ApplicationController::class, 'saveVolunteerDetails'])->name('volunteer.details.save');

require __DIR__.'/auth.php';

Route::get('/application/step0', [ApplicationController::class, 'step0'])->name('application.step0');
Route::get('/application/step1', [ApplicationController::class, 'step1'])->name('application.step1');
Route::get('/application/step2', [ApplicationController::class, 'step2'])->name('application.step2');
Route::get('/application/step3', [ApplicationController::class, 'step3'])->name('application.step3');
Route::get('/application/step4', [ApplicationController::class, 'step4'])->name('application.step4');
Route::get('/application/step5', [ApplicationController::class, 'step5'])->name('application.step5');
Route::get('/application/step6', [ApplicationController::class, 'step6'])->name('application.step6');
Route::get('/application/step7', [ApplicationController::class, 'step7'])->name('application.step7');
