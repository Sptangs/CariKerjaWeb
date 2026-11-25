<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController; // Wajib ditambahkan di Laravel 11
use App\Http\Controllers\ShuttleController;
Route::resource('shuttles', ShuttleController::class);

//INI BUAT LOKASI ROUTE ATAU WEB NYA atau URL gitulah
Route::get('/', [PageController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/service', [PageController::class, 'service']);

//4311
Route::get('/pendaftar', [PageController::class, 'pendaftar']);
Route::get('/pendaftar-master', [PageController::class, 'pendaftar_master']);

Route::get('/pendaftar2', [PageController::class, 'pendaftar2']);
Route::get('/pendaftar2-master', [PageController::class, 'pendaftar2_master']); //eh, ini yang mana yak? perlu kah? kayaknya enggak
// soalnya di pagecontroller nggak ada ituannya
