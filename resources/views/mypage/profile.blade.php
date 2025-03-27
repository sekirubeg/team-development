@extends('layouts.mypage')

@section('title')
    プロフィール
@endsection

@section('content')
   <div class="profile-container">
        <div class="profile-card">
            <h1>プロフィール</h1>

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
                <p><strong>作成日時：</strong>{{ \Carbon\Carbon::parse($user->created_at)->format('Y年m月d日 H:i') }}</p>
            </div>

            <div class="profile-buttons">
                <a href="{{ route('my_page.edit') }}" class="btn">プロフィールを編集</a>
                <a href="{{ route('home') }}" class="btn btn-secondary">ホームに戻る</a>
            </div>
        </div>
    </div>
@endsection