<?php

use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('home');
Route::view('/privasi', 'pages.privacy')->name('privacy');
Route::get('/robots.txt', function () {
    $rules = app()->isProduction() && ! config('wedding.preview') ? "User-agent: *\nAllow: /\nSitemap: ".route('sitemap') : "User-agent: *\nDisallow: /";

    return response($rules, 200)->header('Content-Type', 'text/plain');
})->name('robots');
Route::get('/sitemap.xml', function () {
    return response(view('pages.sitemap'), 200)->header('Content-Type', 'application/xml');
})->name('sitemap');
