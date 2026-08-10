<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// Storage files (from database - Wasmer has ephemeral filesystem)
Route::get('/uploads/{id}', function ($id) {
    $file = \App\Models\FileUpload::findOrFail($id);
    $decoded = base64_decode($file->data);
    return response($decoded, 200, [
        'Content-Type' => $file->type ?? 'application/octet-stream',
        'Content-Disposition' => 'inline; filename="' . $file->name . '"',
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('id', '[0-9]+');

// Legacy storage route (for old files)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    $mime = mime_content_type($fullPath);
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('path', '.*');

// Site Routes
Route::controller('App\Http\Controllers\SiteController')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/about', 'about')->name('about');
    Route::get('/support', 'support')->name('support');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/privacy', 'privacy')->name('privacy');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('/maintenance-mode', 'maintenance')->name('maintenance');
    Route::get('/placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
});

// User Routes
require __DIR__ . '/user.php';

// Admin Routes
require __DIR__ . '/admin.php';

// Catch-all must be last
Route::controller('App\Http\Controllers\SiteController')->group(function () {
    Route::get('/{slug}', 'pages')->name('pages');
});
