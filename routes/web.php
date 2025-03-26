<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<<<<<<< HEAD
Route::get('/tasks',[TaskController::class, 'index'])->name('tasks.index');
=======
>>>>>>> bd211acd7cdaa1771166c0deb989357c1be106db
