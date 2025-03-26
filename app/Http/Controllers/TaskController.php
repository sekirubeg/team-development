<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Post;

class TaskController extends Controller
{
    public function index()
    {
        // $tasks = Post:all();
        return view('tasks.index');
    }
}
