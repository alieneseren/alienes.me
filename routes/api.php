<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\VisitorCountController;
use App\Http\Controllers\Api\LeaderboardController;

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

/*
|--------------------------------------------------------------------------
| V1 API Routes - New Leaderboard System
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    // Games & Leaderboard (new system)
    Route::prefix('leaderboard')->group(function () {
        Route::get('/games', [LeaderboardController::class, 'games']);
        Route::get('/games/{slug}', [LeaderboardController::class, 'leaderboard']);
        Route::post('/games/{slug}/score', [LeaderboardController::class, 'submitScore']);
    });
    
    // Global stats
    Route::get('/stats', [LeaderboardController::class, 'globalStats']);
    
    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/leaderboard/games/{slug}/my-stats', [LeaderboardController::class, 'myStats']);
    });
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
    Route::get('/active', [VisitorCountController::class, 'activeList']); // Anlık aktif ziyaretçiler
    Route::get('/logs', [VisitorCountController::class, 'logs']);        // Son ziyaret logları
    Route::get('/stream', [VisitorCountController::class, 'stream']);    // SSE gerçek zamanlı stream
    Route::get('/dashboard', [VisitorCountController::class, 'dashboard']); // Dashboard özet
    Route::post('/esp32-log', [VisitorCountController::class, 'esp32Log']); // ESP32 log kaydet
    Route::delete('/esp32-cleanup', [VisitorCountController::class, 'esp32Cleanup']); // ESP32 log temizle
    Route::get('/{date}', [VisitorCountController::class, 'byDate']);    // Belirli tarih
});
