<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
Route::get('/contact', [ContactController::class, 'index'])
    ->middleware('no-cache')
    ->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,60')
    ->name('contact.store');

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
});
