<?php

use App\Http\Controllers\Api\Admin\UserApiController as AdminUserApiController;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CompanyApiController;
use App\Http\Controllers\Api\JobSeekerApiController;
use App\Http\Controllers\Api\JobSeekerProfileApiController;
use App\Http\Controllers\Api\ShuttleApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('throttle:10,1')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [AuthApiController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('api.auth.login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthApiController::class, 'logout'])->name('api.auth.logout');

    Route::middleware('role:company')->prefix('company')->name('api.company.')->group(function () {
        Route::get('/dashboard', [CompanyApiController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [CompanyApiController::class, 'profile'])->name('profile.show');
        Route::put('/profile', [CompanyApiController::class, 'updateProfile'])->name('profile.update');
        Route::get('/jobs', [CompanyApiController::class, 'jobs'])->name('jobs.index');
        Route::post('/jobs', [CompanyApiController::class, 'storeJob'])->name('jobs.store');
        Route::get('/jobs/{jobPosting}', [CompanyApiController::class, 'showJob'])->name('jobs.show');
        Route::put('/jobs/{jobPosting}', [CompanyApiController::class, 'updateJob'])->name('jobs.update');
        Route::patch('/jobs/{jobPosting}/close', [CompanyApiController::class, 'closeJob'])->name('jobs.close');
        Route::get('/jobs/{jobPosting}/applications', [CompanyApiController::class, 'applications'])
            ->name('jobs.applications.index');
        Route::patch('/applications/{application}/status', [CompanyApiController::class, 'updateApplicationStatus'])
            ->name('applications.status');
        Route::get('/applications/{application}/cv', [CompanyApiController::class, 'downloadApplicantCv'])
            ->name('applications.cv');
        Route::get('/reports/applications', [CompanyApiController::class, 'exportExcel'])
            ->name('reports.applications');
    });

    Route::middleware('role:job_seeker')->prefix('job-seeker')->name('api.job-seeker.')->group(function () {
        Route::get('/dashboard', [JobSeekerApiController::class, 'dashboard'])->name('dashboard');
        Route::get('/jobs', [JobSeekerApiController::class, 'jobs'])->name('jobs.index');
        Route::get('/jobs/{job}', [JobSeekerApiController::class, 'showJob'])->name('jobs.show');
        Route::get('/jobs/{job}/application', [JobSeekerApiController::class, 'applicationForm'])
            ->name('jobs.application');
        Route::post('/jobs/{job}/applications', [JobSeekerApiController::class, 'apply'])
            ->name('jobs.applications.store');
        Route::get('/applications', [JobSeekerApiController::class, 'applications'])
            ->name('applications.index');

        Route::get('/profile', [JobSeekerProfileApiController::class, 'show'])->name('profile.show');
        Route::put('/profile', [JobSeekerProfileApiController::class, 'update'])->name('profile.update');
        Route::get('/profile/cv', [JobSeekerProfileApiController::class, 'downloadCv'])->name('profile.cv');
        Route::delete('/profile/cv', [JobSeekerProfileApiController::class, 'deleteCv'])->name('profile.cv.delete');
    });

    Route::middleware('role:admin')->prefix('admin')->name('api.admin.')->group(function () {
        Route::get('/dashboard', [AdminApiController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminUserApiController::class, 'index'])->name('users.index');
    });

    Route::middleware('role:admin')->group(function () {
        Route::post('/users', [AdminUserApiController::class, 'store'])->name('api.users.store');
        Route::get('/users/{id}', [AdminUserApiController::class, 'show'])->name('api.users.show');
        Route::get('/users', [AdminUserApiController::class, 'index'])->name('api.users.index');
        Route::post('/shuttles', [ShuttleApiController::class, 'store'])->name('api.shuttles.store');
        Route::put('/shuttles/{shuttle}', [ShuttleApiController::class, 'update'])->name('api.shuttles.update');
    });
});

Route::get('/shuttles', [ShuttleApiController::class, 'index'])->name('api.shuttles.index');
Route::get('/shuttles/{shuttle}', [ShuttleApiController::class, 'show'])->name('api.shuttles.show');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
