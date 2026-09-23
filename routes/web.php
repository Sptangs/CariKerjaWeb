<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudController;

Route::get('/bud', [BudController::class, 'index']);
Route::post('/bud/hitung', [BudController::class, 'hitung']);

Route::get('/', function () {
    return view('welcome');
});
