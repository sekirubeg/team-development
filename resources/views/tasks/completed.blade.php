@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">完了済みタスク</h2>

    @if ($tasks->isEmpty())
        <p>完了済みのタスクはありません。</p>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}" class="card-img-top" alt="画像">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="card-text">{{ $task->content }}</p>
                            <small class="text-muted">完了日：{{ \Carbon\Carbon::parse($task->updated_at)->format('Y年m月d日') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
