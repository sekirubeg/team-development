<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\My_pageController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/my_page', [App\Http\Controllers\My_pageController::class, 'index'])->name('my_page');





Route::get('/tasks/{task}/edit',[TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}',[TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}',[TaskController::class, 'destroy'])->name('tasks.destroy');

// web.php
Route::post('/bookmarks/{id}', [BookmarkController::class, 'store'])->name('bookmarks.bookmark');
Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy'])->name('bookmarks.unbookmark');



Route::prefix('my_page')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [My_pageController::class, 'index'])->name('my_page');
        Route::get('/edit', [My_pageController::class, 'edit'])->name('my_page.edit');
        Route::post('/update', [My_pageController::class, 'update'])->name('my_page.update');
});

Route::get('/task/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/task/store', [TaskController::class, 'store'])->name('tasks.store');

Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
Route::get('/comments/create/{task_id}', [CommentController::class, 'create'])->name('comment.create');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

// routes/web.php
Route::patch('/tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks/completed', [TaskController::class, 'completed'])->name('tasks.completed');
});