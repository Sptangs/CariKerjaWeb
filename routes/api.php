<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShuttleApiController;
use App\Http\Controllers\ShuttleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/shuttles', [ShuttleApiController::class, 'index']);
Route::get('/shuttles/{id}', [ShuttleApiController::class, 'show']);
Route::post('/entitas', [ApiController::class, 'store']);
Route::post('/shuttles', [ShuttleApiController::class, 'store']);
Route::post('/shuttles', [ShuttleController::class, 'store']);