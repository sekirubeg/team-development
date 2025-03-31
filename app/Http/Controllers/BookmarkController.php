<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Notifications\LikeNotification;

class BookmarkController extends Controller
{
    //
    public function store(Request $request, $id)
    {
        $task = Task::with('user')->findOrFail($id);
        Auth::user()->bookmark($id);
        $task->user->notify(new LikeNotification($task));

        return back();
    }
    public function destroy(Request $request, $id)
    {
        Auth::user()->unbookmark($id);
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
