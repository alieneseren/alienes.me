<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\ProfileController as PublicProfileController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\StudyCategoryController;
use App\Http\Controllers\Admin\StudyNoteController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Admin\CvController;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Bacanaks Subdomain Routes (bacanaks.alienes.me)
Route::domain('bacanaks.alienes.me')->group(function () {
    Route::get('/', function () {
        return response()->file(public_path('bacanaks/index.html'));
    })->name('bacanaks.subdomain.index');
    
    Route::get('/{file}', function ($file) {
        $filePath = public_path("bacanaks/{$file}");
        
        // Eğer dosya yoksa ve uzantısı yoksa .html ekleyip dene
        if (!file_exists($filePath) && !pathinfo($filePath, PATHINFO_EXTENSION)) {
            $filePath .= '.html';
        }
        
        if (file_exists($filePath)) {
            $mimeType = File::mimeType($filePath);
            // JS dosyaları için doğru mime type
            if (str_ends_with($filePath, '.js')) {
                $mimeType = 'text/javascript';
            } else if (str_ends_with($filePath, '.css')) {
                $mimeType = 'text/css';
            }
            
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
        
        abort(404);
    })->where('file', '.*')->name('bacanaks.subdomain.show');
});

// Games Subdomain Routes (games.alienes.me)
Route::domain('games.alienes.me')->group(function () {
    // API Routes for Subdomain
    Route::prefix('api/games')->name('games.subdomain.api.')->group(function () {
        Route::post('/score', [GameController::class, 'saveScore'])->name('score.save');
        Route::get('/leaderboard/{game}', [GameController::class, 'getLeaderboard'])->name('leaderboard.show');
        Route::get('/leaderboards', [GameController::class, 'getAllLeaderboards'])->name('leaderboards.index');
        Route::get('/score/{game}/{username}', [GameController::class, 'getUserScore'])->name('score.user');
    });

    Route::get('/', function () {
        return response()->file(public_path('games/index.html'));
    })->name('games.subdomain.index');
    
    Route::get('/{file}', function ($file) {
        $filePath = public_path("games/{$file}");
        
        // Eğer dosya yoksa ve uzantısı yoksa .html ekleyip dene
        if (!file_exists($filePath) && !pathinfo($filePath, PATHINFO_EXTENSION)) {
            $filePath .= '.html';
        }
        
        if (file_exists($filePath)) {
            $mimeType = File::mimeType($filePath);
            // JS dosyaları için doğru mime type
            if (str_ends_with($filePath, '.js')) {
                $mimeType = 'text/javascript';
            } else if (str_ends_with($filePath, '.css')) {
                $mimeType = 'text/css';
            }
            
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
        
        abort(404);
    })->where('file', '.*')->name('games.subdomain.show');
});

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
Route::get('/games', function () {
    return view('games');
})->name('games');
Route::get('/contact', [ContactController::class, 'index'])
    ->middleware('no-cache')
    ->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,60')
    ->name('contact.store');

// Study Notes Routes (Çalışma Notları)
Route::prefix('study')->name('study.')->group(function () {
    Route::get('/', [StudyController::class, 'index'])->name('index');
    Route::get('/{categorySlug}', [StudyController::class, 'category'])->name('category');
    Route::get('/{categorySlug}/{noteSlug}', [StudyController::class, 'show'])->name('show');
});

// Games Routes (Oyunlar)
// Redirect legacy /games.html links to the games subdomain root to ensure
// buttons or links that still point to /games.html land on the correct
// subdomain entry point.
Route::get('/games.html', function () {
    return redirect()->away('https://games.alienes.me');
})->name('games.index');

Route::get('/games/{game}', function ($game) {
    $filePath = public_path("games/{$game}.html");
    
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
    
    abort(404);
})->where('game', '[a-z0-9-]+')->name('games.show');

// Game API Routes
Route::prefix('api/games')->name('api.games.')->group(function () {
    Route::post('/score', [\App\Http\Controllers\GameController::class, 'saveScore'])->name('save-score');
    Route::get('/leaderboard/{gameName}', [\App\Http\Controllers\GameController::class, 'getLeaderboard'])->name('leaderboard');
    Route::get('/leaderboard/{gameName}/{username}', [\App\Http\Controllers\GameController::class, 'getUserScore'])->name('user-score');
    Route::get('/leaderboards', [\App\Http\Controllers\GameController::class, 'getAllLeaderboards'])->name('all-leaderboards');
});

// GitHub Profile Routes
Route::get('/api/github/user', [PublicProfileController::class, 'getGithubUser'])->name('github.user');
Route::get('/github/avatar', [PublicProfileController::class, 'getGithubAvatar'])->name('github.avatar');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Password Change (requires authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.update');
    });
});

// Admin Panel Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/image', [ProfileController::class, 'deleteImage'])->name('profile.delete-image');
    Route::post('/profile/sync-github', [ProfileController::class, 'syncFromGithub'])->name('profile.sync-github');
    
    // Experience Management
    Route::resource('experiences', ExperienceController::class)->except(['show']);
    
    // Education Management
    Route::resource('educations', EducationController::class)->except(['show']);
    
    // Skills Management
    Route::resource('skills', SkillController::class)->except(['show']);
    
    // Projects Management
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::get('/projects/github/repos', [ProjectController::class, 'getGithubRepos'])->name('projects.github.repos');
    Route::get('/projects/github/users', [ProjectController::class, 'getGithubUsers'])->name('projects.github.users');
    Route::post('/projects/github/import', [ProjectController::class, 'importFromGithub'])->name('projects.github.import');
    
    // Contact Messages
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/{contact}/read', [AdminContactController::class, 'markAsRead'])->name('contacts.read');
    
    // Study Categories Management
    Route::resource('study-categories', StudyCategoryController::class)->except(['show']);
    
    // Study Notes Management
    Route::resource('study-notes', StudyNoteController::class)->except(['show']);
    
    // CV Management
    Route::resource('cv', CvController::class);
    Route::post('cv/{cv}/publish', [CvController::class, 'publish'])->name('cv.publish');
});

// Frontend CV Route
Route::get('/cv', function () {
    $cv = \App\Models\Cv::where('is_published', true)->firstOrFail();
    return view('frontend.cv', compact('cv'));
})->name('cv.show');
