<?php

namespace App\Http\Controllers;

use App\Models\Task; 
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function create()
    {
        return view('tasks.create'); 
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'priority' => 'required|integer|between:1,3',
        'due_date' => 'nullable|date',
    ]);

    
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('task_images', 'public');
    }

    
    Task::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => auth()->id(),
        'image_path' => $imagePath,
        'priority' => $request->priority,
        'due_date' => $request->due_date,
    ]);

    // return redirect()->route('tasks.index')->with('success', 'タスクを作成しました！');
}

}

