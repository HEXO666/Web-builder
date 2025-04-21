<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SectionController as AdminSectionController;
use App\Http\Controllers\Admin\ThemeController as AdminThemeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsiteSectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes are already included with Laravel UI

// Public routes
Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');
Route::get('/themes/{theme}', [ThemeController::class, 'show'])->name('themes.show');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Website routes
    Route::resource('websites', WebsiteController::class);
    
    // Website section routes
    Route::get('/websites/{website}/builder', [WebsiteController::class, 'builder'])->name('websites.builder');
    Route::post('/websites/{website}/sections', [WebsiteSectionController::class, 'store'])->name('website.sections.store');
    
    // Direct route for adding sections (no route parameter)
    Route::post('/add-section-to-website', [WebsiteSectionController::class, 'addToWebsite'])->name('website.add.section');
    
    Route::put('/websites/{website}/sections/{websiteSection}', [WebsiteSectionController::class, 'update'])->name('website.sections.update');
    Route::delete('/websites/{website}/sections/{websiteSection}', [WebsiteSectionController::class, 'destroy'])->name('website.sections.destroy');
    Route::post('/websites/{website}/sections/reorder', [WebsiteSectionController::class, 'reorder'])->name('website.sections.reorder');
    
    // Website preview and export
    Route::get('/websites/{website}/preview', [WebsiteController::class, 'preview'])->name('websites.preview');
    Route::post('/websites/{website}/export', [ExportController::class, 'export'])->name('websites.export');
    Route::get('/websites/{website}/download', [ExportController::class, 'download'])->name('websites.download');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('sections', AdminSectionController::class);
    Route::resource('themes', AdminThemeController::class);
    Route::post('/themes/{theme}/variables', [AdminThemeController::class, 'storeVariable'])->name('themes.variables.store');
    Route::put('/themes/{theme}/variables/{variable}', [AdminThemeController::class, 'updateVariable'])->name('themes.variables.update');
    Route::delete('/themes/{theme}/variables/{variable}', [AdminThemeController::class, 'destroyVariable'])->name('themes.variables.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
