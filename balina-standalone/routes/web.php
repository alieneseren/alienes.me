<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Balina Optimization Dashboard
|--------------------------------------------------------------------------
| Standalone version of the Balina Optimization Dashboard
*/

// Ana sayfa - Optimization Dashboard
Route::get('/', function () {
    return view('optimization.dashboard');
})->name('home');

// API route for any future needs
Route::prefix('api')->group(function () {
    // API routes can be added here if needed
});
