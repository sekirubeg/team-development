@extends('layouts.app')

@section('styles')
<style>
        body {
        background: linear-gradient(120deg, #fdfbfb, #ebedee);
        font-family: 'Segoe UI', sans-serif;
    }

    .profile-wrapper {
        max-width: 1000px;
        margin: auto;
        padding: 40px 20px;
    }

    .profile-card {
        display: flex;
        background-color: #ffffffd9;
        justify-content: center;
        border-radius: 16px;
        padding: 30px;
        align-items: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        gap: 30px;
    }

    .profile-image img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #0d6efd50;
    }

    .profile-info p {
        font-size: 1rem;
        margin: 6px 0;
    }

    .profile-info strong {
        color: #0d6efd;
    }

    .profile-buttons {
        margin-top: 20px;
        display: flex;
        gap: 12px;
    }

    .task-card {
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        background: #fff;
        border: none;
    }

    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .card-title {
        font-weight: 600;
    }

    .task-badge {
        font-size: 0.75rem;
        background: #e3f2fd;
        color: #007bff;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .heart-icon {
        color: #e74c3c;
    }
</style>
@endsection

@section('content')
<div class="profile-wrapper" style="padding-top:0;">
    <div class="container" style="margin-top:10px;">
    <h2 class="text-center mb-4">プロフィール</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        <div class="profile-card mb-5">
            <div class="profile-image">
                <img src="{{ asset('storage/' . $user->image_at) }}" alt="プロフィール画像">
            </div>
            <div class="profile-info">
                
                <p><strong> 名前：</strong>{{ $user->name }}</p>
                <p><strong> メール：</strong>{{ $user->email }}</p>
                <p><strong> 自己紹介：</strong>{{ $user->description }}</p>
                <p><strong> 登録日：</strong>{{ \Carbon\Carbon::parse($user->created_at)->format('Y年m月d日 H:i') }}</p>
                <div class="profile-buttons">
                    <a href="{{ route('my_page.edit') }}" class="btn btn-primary">プロフィールを編集</a>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">ホームに戻る</a>
                </div>
            </div>
        </div>
    </div>


    <h3 class="mb-3" style="text-align:center;">📋 自分のタスク</h3>
    <div class="row">
        @foreach ($tasks as $task)
        <div class="col-md-4 mb-4">
            <div class="card task-card h-100">
                <img src="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $task->title }}</h5>
                    <p class="card-text">{{ Str::limit($task->content, 100) }}</p>
                    <div class="d-flex justify-content-between">

                             @if (Auth::id() == $task->user_id)
                                
                             <a href="{{ route("tasks.edit", $task->id) }}" class="btn btn-outline-primary d-flex justify-content-center align-items-center p-0" style="width: 40px; height: 40px; background-color: transparent;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                     class="bi bi-pencil" viewBox="0 0 16 16" style="vertical-align: middle; color: var(--bs-primary);">
                                    <path d="M12.146 0.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-1.5 1.5-3-3 1.5-1.5a.5.5 0 0 1 0-.708zM0 13.5V16h2.5l9.854-9.854-2.5-2.5L0 13.5z"/>
                                </svg>
                            </a>

                            <form method="post" action="{{ route('tasks.destroy', $task->id) }}" style="margin-bottom: 0;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger d-flex justify-content-center align-items-center p-0" style="width: 40px; height: 40px; background-color: transparent;" onclick="return confirm('削除してよろしいですか？')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                         class="bi bi-trash" viewBox="0 0 16 16" style="vertical-align: middle; color: var(--bs-danger);">
                                        <path d="M5.5 5.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h2.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1z"/>
                                    </svg>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('tasks.complete', $task->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success d-flex justify-content-center align-items-center p-0 mx-2" style="width: 40px; height: 40px; background-color: transparent;" onclick="return confirm('完了してよろしいですか？')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                         class="bi bi-check-square-fill" viewBox="0 0 16 16"  style="vertical-align: middle; color: var(--bs-success);">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                    </svg>
                                </button>
                            </form>

                            @endif

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h3 class="mt-5 mb-3" style="text-align:center;">❤️ いいねしたタスク</h3>
    <div class="row">
        @foreach ($likedTasks as $task)
        <div class="col-md-4 mb-4">
            <div class="card task-card h-100">
                <img src="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        {{ $task->title }}
                        <i class="fa-solid fa-heart heart-icon"></i>
                    </h5>
                    <p class="card-text">{{ Str::limit($task->content, 100) }}</p>
                    <p class="text-muted small">👍 {{ $task->bookmarks_count }} いいね</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
