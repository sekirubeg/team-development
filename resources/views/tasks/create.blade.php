@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>タスク作成</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">タイトル:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">内容:</label>
                <textarea id="content" name="content" rows="4" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="priority">優先度:</label>
                <select id="priority" name="priority" class="form-control">
                    <option value="1">低</option>
                    <option value="2">中</option>
                    <option value="3">高</option>
                </select>
            </div>

            <div class="form-group">
                <label for="due_date">期限:</label>
                <input type="date" id="due_date" name="due_date" class="form-control">
            </div>

            <div class="form-group">
                <label for="image">画像アップロード:</label>
                <input type="file" id="image" name="image" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">作成</button>
            
        </form>
    </div>
@endsection

@if ($errors->has('name'))
<div>
{{ $errors->first('name') }}
</div>
@endif