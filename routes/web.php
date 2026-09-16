<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController; // Wajib ditambahkan di Laravel 11

Route::get('/', [PageController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/service', [PageController::class, 'service']);