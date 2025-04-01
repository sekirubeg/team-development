@extends('layouts.app')

@section('title')
    タスク変更
@endsection

@section('content')
<div class="container mt-5" style="max-width: 800px;">
    {{-- リダイレクトの際withで指定した文字を出力 --}}
    <div class="card shadow-lg p-4">
        <h2 class="mb-4 text-center">タスクの編集</h2>

        <form method="POST" action="{{ route('tasks.update', $task) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- タイトル --}}
            <div class="mb-3">
                <label for="title" class="form-label">タイトル:</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $task->title) }}">
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 内容 --}}
            <div class="mb-3">
                <label for="content" class="form-label">内容:</label>
                <textarea id="content" name="content" rows="4" class="form-control">{{ old('content', $task->content) }}</textarea>
                @error('content')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 優先度 --}}
            <div class="mb-3">
                <label for="priority" class="form-label">優先度:</label>
                <select id="priority" name="importance" class="form-select">
                    <option value="" disabled>選択してください</option>
                    <option value="1" {{ old('importance', $task->importance) == 1 ? 'selected' : '' }}>低</option>
                    <option value="2" {{ old('importance', $task->importance) == 2 ? 'selected' : '' }}>中</option>
                    <option value="3" {{ old('importance', $task->importance) == 3 ? 'selected' : '' }}>高</option>
                </select>
                @error('importance')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 期限 --}}
            <div class="mb-3">
                <label for="due_date" class="form-label">期限:</label>
                <input type="date" id="due_date" name="limit" class="form-control" value="{{ old('limit', $task->limit) }}">
                @error('limit')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 画像アップロード --}}
            <div class="mb-3">
                <label for="image" class="form-label">画像アップロード:</label>
                <input type="file" id="image" name="image_at" class="form-control">
                @if ($task->image_at)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $task->image_at) }}" alt="画像" style="max-width: 200px;" class="rounded shadow-sm">
                    </div>
                @endif
                @error('image_at')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary px-4">更新</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary px-4">キャンセル</a>
            </div>
        </form>
    </div>
</div>
@endsection
