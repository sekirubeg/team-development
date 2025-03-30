{{-- あいこさんのヘッダーを表示させるために、layouts/app.blade.phpにextends --}}
@extends('layouts.app')

@section('title')
    プロフィール
@endsection

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
   <div class="profile-container">
        <div class="profile-card">
            <h1>プロフィール</h1>
            {{-- リダイレクトの際withで指定した文字を出力 --}}
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="profile-image">
                <img src="{{ asset('storage/' . $user->image_at) }}" alt="プロフィール画像">
            </div>

            <div class="profile-info">
                <p><strong>名前：</strong>{{ $user->name }}</p>
                <p><strong>メールアドレス：</strong>{{ $user->email }}</p>
                <p><strong>自己紹介：</strong>{{ $user->description }}</p>
                <p><strong>作成日時：</strong>{{ \Carbon\Carbon::parse($user->created_at)->format('Y年m月d日 H:i') }}</p>
            </div>

            <div class="profile-buttons">
                <a href="{{ route('my_page.edit') }}" class="btn btn btn-primary px-5">プロフィールを編集</a>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">ホームに戻る</a>
            </div>
        </div>
    </div>
    <h1>自分のタスク</h1>
    @foreach ($tasks as $task)
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/sample.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">タイトル : {{ $task->title }}</h5>
                            <p class="card-text">内容 : {{ $task->content }}</p>
                            <a href="{{ route("tasks.edit", $task->id) }}" class="btn btn-primary">Edit</a>
                            <form  method="post" action="{{ route('tasks.destroy', $task->id) }}" class="btn btn-danger">
                                @csrf
                                @method('delete')
                                <input type="submit" value="削除" onclick="return confirm('削除してよろしいですか?')" style="background-color: transparent; border: none; color: white;">

                            </form>
                        </div>
                    </div>
                </div>
    @endforeach
    <h1>いいねをつけたタスク</h1>
    <div class="container mt-4">
    <div class="row">
        @foreach ($likedTasks as $task)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="img/sample.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">タイトル : {{ $task->title }}</h5>
                        <p class="card-text">内容 : {{ $task->content }}</p>
                        <p>いいね数: {{ $task->bookmarks_count }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection