<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\My_pageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/tasks',[TaskController::class, 'index'])->name('tasks.index');

Route::get('/tasks/{id}',[TaskController::class,'show'])->name('tasks.show');

// ルートをグループ化しており、全てのurlがmy_pageから始まり、authを適用させている
Route::prefix('my_page')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [My_pageController::class, 'index'])->name('my_page');
        Route::get('/edit', [My_pageController::class, 'edit'])->name('my_page.edit');
        Route::post('/update', [My_pageController::class, 'update'])->name('my_page.update');
    });
Route::post('/task/create', [App\Http\Controllers\HomeController::class, 'task/'])->name('posts.create');

