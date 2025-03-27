<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class My_pageController extends Controller
{
    //マイページ表示（ユーザidを取得しそれによってviewの表示を変更する)
    public function index()
    {
        $id = Auth::id();
        $user = DB::table('users')->find($id);
        $tasks = DB::table('tasks')->where('user_id', $id)->get();
        return view('mypage.profile', ['user' => $user, 'tasks' => $tasks]);
    }

    //マイページ編集画面表示
    public function edit()
    {
        $id = Auth::id();
        $user = DB::table('users')->find($id);
        return view('mypage.profile_edit', ['user' => $user]);
    }

    //マイページ編集処理
    public function update(Request $request)
    {
        //バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string|max:255',
            'image_at' => 'nullable|image|max:2048',
        ]);

        $id = Auth::id();
        $user = User::find($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->description = $validated['description'];


        //画像が選択されている場合
        if ($request->hasFile('image_at')) {
            // 画像を /storage/app/public/images ディレクトリに保存し、パスを取得
            $path = $request->file('image_at')->store('images', 'public');

            // 実際にDBへ保存するのは $user->image_at カラムに対して行う
            $user->image_at = $path;
        };
        $user->save();
        return redirect()
            ->route('my_page')
            ->with('success', 'ユーザー情報を更新しました！');
    }
}
