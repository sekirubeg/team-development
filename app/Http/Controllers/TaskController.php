<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
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

        'content' => 'required|string',
        'image_at' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'importance' => 'required|integer|between:1,3',
        'limit' => 'required|date',
    ], [
        'title.required' => 'タイトルを入力してください。',
        'title.string' => 'タイトルは文字列である必要があります。',
        'title.max' => 'タイトルは最大255文字までです。',
        
        'content.required' => '内容を入力してください。',
        'content.string' => '内容は文字列である必要があります。',

        'importance.required' => '優先度を選択してください。',
        'importance.integer' => '優先度は数値である必要があります。',
        'importance.between' => '優先度は1〜3の間で選択してください。',

        'limit.required' => '期限日を入力してください。',
        'limit.date' => '有効な日付を入力してください。',
        'limit.after_or_equal' => '期限日は今日以降の日付を選択してください。',

        'image.required' => '画像をアップロードしてください。',
        'image.image' => 'アップロードできるのは画像ファイルのみです。',
        'image.mimes' => '画像の形式はjpeg, png, jpg, gifのいずれかにしてください。',
        'image.max' => '画像のサイズは最大2MBまでです。',
=======
        'content' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'importance' => 'required|integer|between:1,3',
        'limit' => 'nullable|date',


    ]);

    
    $image_at= null;
    if ($request->hasFile('image')) {
        $image_at = $request->file('image')->store('task_images', 'public');
    }

    
    Task::create([
        'title' => $request->title,
        'content' => $request->content,

        'user_id' => Auth::id(),
        'image_at' => $imagePath,

        'importance' => $request->importance,
        'limit' => $request->limit,
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