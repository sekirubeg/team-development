@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">完了済みタスク</h2>

    @if ($tasks->isEmpty())
        <p>完了済みのタスクはありません。</p>
    @else
        <div class="row" style="max-width:1200px ; margin:auto;">
            @foreach ($tasks as $task)
                <div class="col-md-4 mb-4" style="width:300px;" >
                    <div class="card task-card h-100">
                        <img src="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}"
                            class="card-img-top" style="height: 200px; object-fit: cover; border-bottom: 1px solid #dee2e6;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="card-text">{{ Str::limit($task->content, 100) }}</p>
                            <div class="d-flex justify-content-between">

                                @if (Auth::id() == $task->user_id)


                                    <form method="post" action="{{ route('tasks.destroy', $task->id) }}"
                                        style="margin-bottom: 0; margin:0 auto ;" >
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn btn-outline-danger d-flex justify-content-center align-items-center p-0"
                                            style="width: 40px; height: 40px; background-color: transparent;"
                                            onclick="return confirm('削除してよろしいですか？')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"
                                                style="vertical-align: middle; color: var(--bs-danger);">
                                                <path
                                                    d="M5.5 5.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h2.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1z" />
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

        <div class="d-flex justify-content-center">
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
