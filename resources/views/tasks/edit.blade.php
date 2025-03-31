{{-- あいこさんのヘッダーを表示させるために、layouts/app.blade.phpにextends --}}
@extends('layouts.app')

@section('title')
    task変更
@endsection

@section('styles')

<style>
    .navbar .nav-link.dropdown-toggle {
        font-size: 16px;
        font-family: 'Nunito', sans-serif;
    }
</style>
    
@endsection

@section('content')
    <form method = "post" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

            <p>
                <label>タイトル</label>
                <input type="text" name="title" value="{{ data_get($task, 'title') }}">
            </p>

            <p>
                <label>内容</label>
                <input type="text" name="content" value="{{ data_get($task, 'content') }}">
            </p>
            <input type="submit" value="更新">
    </form>
@endsection