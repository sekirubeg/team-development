<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('comments')
            ->withCount('bookmarks');



        if($request->has('search') && $request->filled('search')){
            $searchKeyword = $request->input('search');
            $query->where('title', 'like', '%'. $searchKeyword . '%');
        }
        $tasks = $query->paginate(6);

        if ($request->filled('search')) {
            $tasks->appends(['search' => $request->search]);
        }
        return view('tasks.index', compact('tasks'));
    }

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
        'image_at' => $imagePath,
        'importance' => $request->priority,
        'limit' => $request->due_date,
    ]);

    return redirect()->route('tasks.index')->with('success', 'タスクを作成しました！');
}





    public function edit(Task $task)
    {
        Gate::authorize('update', $task);
        $data= old() ?: $task;
        return view('tasks.edit',compact('task', 'data'));
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('update', $task);
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $task->title = $request->title;
        $task->content = $request->content;
        $task->save();

        return redirect()->route('my_page');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('update', $task);
        $task->delete();
        return redirect()->route('my_page');
    }




    public function comment_destroy(Task $task)
    {
        $task->comments()->delete();
        $task->delete();
        return redirect()->route('home')->with('message', '投稿を削除しました');
    }
}