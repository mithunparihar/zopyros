<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/awards', 'awards')->name('awards');
    Route::get('/projects/{alias?}', 'projects')->name('projects');
    Route::get('/testimonials', 'testimonials')->name('testimonials');
    Route::get('/team', 'team')->name('team');
    Route::get('/blog/{alias?}', 'blog')->name('blog');
});

Route::get('/image/{path}/ws_{width}/{filename}', function ($path, $width, $filename) {
    $binary = \Image::getBinary($path, $width, $filename);
    return response($binary, 200)
        ->header('Content-Type', 'image/avif')
        ->header('Cache-Control', 'public, max-age=31536000');
})->name('image.resize');
