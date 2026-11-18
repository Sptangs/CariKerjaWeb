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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users/{id}', [App\Http\Controllers\Api\UserApiController::class, 'show']);
Route::get('/users', [App\Http\Controllers\Api\UserApiController::class, 'index']);
