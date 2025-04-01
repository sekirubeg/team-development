<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('comments')
            ->withCount('bookmarks')
            ->with('tags')
            ->whereDate('limit', '>=', now())         // 期限が今日以降
            ->where('is_completed', false);           // 未完了のみ
          
        
        if($request->has('search') && $request->filled('search')){
            $searchKeyword = $request->input('search');
            $query->where('title', 'like', '%'. $searchKeyword . '%');
        }

        $sortType = $request->input('sort', 'newest');
       
        switch ($sortType) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'good':
                $query->orderBy('bookmarks_count', 'desc');
                break;
            case 'important':
                $query->orderBy('importance', 'desc');
                break;
            case 'deadline':
                $query->orderBy('limit', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $tasks = $query->paginate(6)->appends($request->query());

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
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255|min:3',
            'content' => 'required|string|min:10',
            'image_at' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'importance' => 'required|integer|between:1,3',
            'limit' => 'required|date',
        ], [
            'title.required' => 'タイトルを入力してください。',
            'title.string' => 'タイトルは文字列である必要があります。',
            'title.max' => 'タイトルは最大255文字までです。',
            'title.min' => 'タイトルは最小3文字以上である必要があります。',
    
            'content.required' => '内容を入力してください。',
            'content.string' => '内容は文字列である必要があります。',
            'content.min' => '内容は最小10文字以上である必要があります。',
    
            'importance.required' => '優先度を選択してください。',
            'importance.integer' => '優先度は数値である必要があります。',
            'importance.between' => '優先度は1〜3の間で選択してください。',
    
            'limit.required' => '期限日を入力してください。',
            'limit.date' => '有効な日付を入力してください。',
    
            'image_at.image' => 'アップロードできるのは画像ファイルのみです。',
            'image_at.mimes' => '画像の形式はjpeg, png, jpg, gifのいずれかにしてください。',
            'image_at.max' => '画像のサイズは最大2MBまでです。',
        ]);
    
        // 画像の保存処理
        if ($request->hasFile('image_at')) {
            $image_at = $request->file('image_at')->store('images', 'public');
        } else {
            $image_at = 'img/task.png'; // デフォルト画像
        }
    
        // タスクを作成
        $task = Task::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'image_at' => $image_at,
            'importance' => $request->importance,
            'limit' => $request->limit,
        ]);
    
        // タグの処理（タグが空でない場合のみ）
        if ($request->filled('tag_name')) {
            $tagNames = explode(' ', trim($request->tag_name));
    
            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(['name' => $name]);
                $task->tags()->attach($tag->id);
            }
        }
    
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

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('update', $task);
        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function comment_destroy(Task $task)
    {
        $task->comments()->delete();
        $task->delete();
        return redirect()->route('home')->with('message', '投稿を削除しました');
    }
}