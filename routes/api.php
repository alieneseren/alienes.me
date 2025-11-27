<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\VisitorCountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->prefix('games')->group(function () {
    Route::post('/score', [GameController::class, 'saveScore']);
    Route::get('/leaderboard/{game}', [GameController::class, 'getLeaderboard']);
    Route::get('/leaderboards', [GameController::class, 'getAllLeaderboards']);
    Route::get('/score/{game}/{username}', [GameController::class, 'getUserScore']);
});

// ESP32 Visitor Count API - CORS enabled for ESP32 access
Route::middleware(['cors'])->prefix('visitor-count')->group(function () {
    Route::get('/', [VisitorCountController::class, 'today']);           // JSON: {"date": "2025-11-27", "count": 42}
    Route::get('/simple', [VisitorCountController::class, 'simple']);    // Plain text: 42
    Route::get('/stats', [VisitorCountController::class, 'stats']);      // Son 7 gün istatistikleri
    Route::get('/{date}', [VisitorCountController::class, 'byDate']);    // Belirli tarih
});
