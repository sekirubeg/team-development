<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\My_pageController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/my_page', [App\Http\Controllers\My_pageController::class, 'index'])->name('my_page');

Route::prefix('my_page')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [My_pageController::class, 'index'])->name('my_page');
        Route::get('/edit', [My_pageController::class, 'edit'])->name('my_page.edit');
        Route::post('/update', [My_pageController::class, 'update'])->name('my_page.update');
});