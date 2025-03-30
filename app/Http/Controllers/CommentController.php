<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function create($task_id)
    {
        $task = Task::with(['comments.user'])->findOrFail($task_id);
        return view('comments.create', compact('task'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:255|',
            'task_id' => 'required|exists:tasks,id',
        ]);

       $task = Task::findOrFail($request->task_id);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->task_id = $task->id;
        $comment->user_id = Auth::id(); // 現在のユーザーIDを取得
        $comment->save();
        // $task->comments()->save($comment);

        return redirect()->route('tasks.index')->with('success', 'コメントを追加しました！');
    }


    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'コメントを削除しました！');
    }


    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }



    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $comment->update([
            'body' => $request->body,
        ]);

        return redirect()->route('tasks.index')->with('success', 'コメントを更新しました！');
    }

}
