@extends('layouts.app')

@section('title', 'タスク作成')

@section('content')
<div class="container mt-5" style="max-width: 800px;">
    {{-- リダイレクトの際withで指定した文字を出力 --}}
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">タスク作成フォーム</h2>

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- タイトル --}}
            <div class="mb-3">
                <label for="title" class="form-label">タイトル:</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 内容 --}}
            <div class="mb-3">
                <label for="content" class="form-label">内容:</label>
                <textarea id="content" name="content" rows="4" class="form-control">{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 優先度 --}}
            <div class="mb-3">
                <label for="priority" class="form-label">優先度:</label>
                <select id="priority" name="importance" class="form-select">
                    <option value="" disabled {{ old('importance') === null ? 'selected' : '' }}>選択してください</option>
                    <option value="1" {{ old('importance') == 1 ? 'selected' : '' }}>低</option>
                    <option value="2" {{ old('importance') == 2 ? 'selected' : '' }}>中</option>
                    <option value="3" {{ old('importance') == 3 ? 'selected' : '' }}>高</option>
                </select>
                @error('importance')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 期限 --}}
            <div class="mb-3">
                <label for="due_date" class="form-label">期限:</label>
                <input type="date" id="due_date" name="limit" class="form-control" value="{{ old('limit') }}">
                @error('limit')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 画像 --}}
            <div class="mb-4">
                <label for="image" class="form-label">画像アップロード:</label>
                <input type="file" id="image" name="image_at" class="form-control">
                @error('image_at')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-5">作成</button>
            </div>
        </form>
    </div>
</div>
@endsection
