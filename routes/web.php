<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobSeekerProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'start'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:job_seeker'])
    ->prefix('job-seeker')
    ->name('job-seeker.')
    ->group(function () {
        Route::get('/dashboard', [JobSeekerProfileController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/profile', [JobSeekerProfileController::class, 'profile'])
            ->name('profile');

        Route::put('/profile', [JobSeekerProfileController::class, 'updateProfile'])
            ->name('profile.update');

        Route::get('/profile/cv', [JobSeekerProfileController::class, 'downloadCv'])
            ->name('profile.cv');
    });

Route::middleware(['auth', 'role:company'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {
        Route::get('/dashboard', [CompanyController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/profile', [CompanyController::class, 'profile'])
            ->name('profile');

        Route::put('/profile', [CompanyController::class, 'updateProfile'])
            ->name('profile.update');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/profile', [AdminController::class, 'profile'])
            ->name('profile');
    });
