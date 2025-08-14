<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/image/{path}/ws_{width}/{filename}', function ($path, $width, $filename) {
    $binary = \Image::getBinary($path, $width, $filename);
    return response($binary, 200)
        ->header('Content-Type', 'image/avif')
        ->header('Cache-Control', 'public, max-age=31536000');
})->name('image.resize');
