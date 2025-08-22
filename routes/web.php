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
    Route::get('/blog-{category}', 'blogcategory')->name('blog.category');

    Route::get('/contact', 'contact')->name('contact');
    Route::get('/career/{alias?}', 'career')->name('career');
    Route::get('/faqs/{category?}', 'faqs')->name('faqs');
    Route::get('/privacy', 'privacy')->name('privacy');
    Route::get('/terms', 'terms')->name('terms');

    Route::get('/thankyou/subscribe', 'thankyouSubscribe')->name('thankyou.subscribe');
    Route::get('/thankyou/contact', 'thankyouContact')->name('thankyou.contact');
    Route::get('/thankyou/career', 'thankyouCareer')->name('thankyou.career');
});

Route::controller(\App\Http\Controllers\SearchController::class)->group(function () {
    Route::get('/search', 'search')->name('search');
});

Route::get('/image/{path}/ws_{width}/{filename}', function ($path, $width, $filename) {
    $binary = \Image::getBinary($path, $width, $filename);
    return response($binary, 200)
        ->header('Content-Type', 'image/avif')
        ->header('Cache-Control', 'public, max-age=31536000');
})->name('image.resize');

Route::controller(App\Http\Controllers\CategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('categories');
    // Route::get('/p/{alias}', 'product')->name('product');
    Route::get('/{category}', 'category')->name('category')->where('category', '^(?!control-panel|sitemap\.xml).*$');
});
