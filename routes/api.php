<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ShuttleApiController;
use App\Http\Controllers\Api\JobPostingApiController;

// Rute User
Route::get('/users/{id}', [UserApiController::class, 'show']);
Route::get('/users', [UserApiController::class, 'index']);

// Rute Shuttle
Route::get('/shuttles', [ShuttleApiController::class, 'index']);
Route::get('/shuttles/{id}', [ShuttleApiController::class, 'show']);
Route::post('/shuttles', [ShuttleApiController::class, 'store']);

// Rute Job Posting (Proyek Kelompok)
Route::get('/job-postings', [JobPostingApiController::class, 'index']);
Route::get('/job-postings/{id}', [JobPostingApiController::class, 'show']);
Route::post('/job-postings', [JobPostingApiController::class, 'store']);