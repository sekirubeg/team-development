@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500;700&display=swap" rel="stylesheet">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 不要(Aiko)　--}}
    <style>
        body {
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .card-text,
        #modalContent {
            word-break: break-word;
            white-space: pre-wrap;
            text-align: left;
            /* 左端から改行 */
        }

        .is-bookmarked {
            color: red;
        }

        .btn-success:hover,
        .btn-success:focus,
        .btn-success:active {
            color: red;
        }

        .btn-success {
            color: red;
        }

        .btn-outline-success:hover,
        .btn-outline-success:focus,
        .btn-outline-success:active {
            color: black;
        }

        .btn-outline-success {
            color: black;
        }
        .pagination .page-item.active .page-link {
            background-color: #B7B8B6; /* 赤 */
            border-color: #B7B8B6;
            color: white;
        }

        .pagination .page-link {
            color: #4CB5F5; /* 通常のリンク色（青）を変えたいときはここ */
        }

        .pagination .page-link:hover {
            background-color: #D1D2D0; /* ホバー時の背景 */
            color: white; /* ホバー時の文字色 */
        }
  <style>
    .custom-edit-button {
        color: #f4cc70;
        border-color: #f4cc70;
    }

    .custom-edit-button:hover,
    .custom-edit-button:focus {
        color: #f4cc70;
        border-color: #f4cc70;
        background-color: rgba(244, 204, 112, 0.15); /* やわらかい黄背景 */
    }

    .custom-delete-button {
        color: #de7a22;
        border-color: #de7a22;
    }

    .custom-delete-button:hover,
    .custom-delete-button:focus {
        color: #de7a22;
        border-color: #de7a22;
        background-color: rgba(222, 122, 34, 0.15); /* やわらかいオレンジ背景 */
    }

    .custom-complete-button {
        color: #20948b;
        border-color: #20948b;
    }

    .custom-complete-button:hover,
    .custom-complete-button:focus {
        color: #20948b;
        border-color: #20948b;
        background-color: rgba(32, 148, 139, 0.15); /* やわらかい青緑背景 */
    }

    .custom-comment-button {
        color: #6ab187;
        border-color: #6ab187;
    }

    .custom-comment-button:hover,
    .custom-comment-button:focus {
        color: #6ab187;
        border-color: #6ab187;
        background-color: rgba(106, 177, 135, 0.15); /* やわらかいグリーン背景 */
    }
</style>

    </style>
@endsection

@section('content')
    @if ($todayTasks->count())
        <div class="alert alert-warning text-center">
            <strong>本日が期限のあなたのタスク</strong>
        </div>
        <div class="container mt-4">
            <div class="row mb-5" style="max-width:1200px; margin:auto;">
                @foreach ($todayTasks as $task)
                    <div class="col-md-4 mb-4" style=" width:300px;">
                        <a href="#" class="task-card" data-title="{{ $task->title }}"
                            data-content="{{ $task->content }}"
                            data-img="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}"
                            data-date="{{ $task->limit }}" style="display:block; text-decoration:none; color:black; "
                            data-bs-toggle="modal" data-bs-target="#taskModal">
                            <div class="card" style="border: 1px ridge #dee2e6;">
                                <img src="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}"
                                    class="card-img-top" alt="タスク画像"
                                    style="height: 220px; border-bottom:1px ridge #dee2e6 ;background-size:contain;" >


                        </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted px-2 pt-2" style="font-size: 0.8rem;">
                                <small>期限日：{{ $task->limit }}</small>
                                <small>重要度：{{ $task->importance }}</small>
                            </div>
                            <div class="mb-2 mt-2">
                                @foreach ($task->tags as $tag)
                                    <span class="badge rounded-pill bg-secondary me-1">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            <h5 class="card-title text-center mt-2">{{ $task->title }}</h5>



                            <div class="d-flex justify-content-between">
                                @if (Auth::id() == $task->user_id)
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="btn custom-edit-button d-flex justify-content-center align-items-center p-0"
                                    style="width: 40px; height: 40px; color:f4cc70; border-color:f4cc70;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"
                                        style="vertical-align: middle;">
                                        <path
                                            d="M12.146 0.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-1.5 1.5-3-3 1.5-1.5a.5.5 0 0 1 0-.708zM0 13.5V16h2.5l9.854-9.854-2.5-2.5L0 13.5z" />
                                    </svg>
                                </a>
                                <form method="post" action="{{ route('tasks.destroy', $task->id) }}"
                                    style="margin-bottom: 0;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="btn custom-delete-button d-flex justify-content-center align-items-center p-0"
                                        style="width: 40px; height: 40px; color:de7a22; border-color:de7a22;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"
                                            style="vertical-align: middle;">
                                            <path
                                                d="M5.5 5.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h2.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1z" />
                                        </svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('tasks.complete', $task->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn custom-complete-button d-flex justify-content-center align-items-center p-0"
                                        style="width: 40px; height: 40px; color:20948b; border-color:20948b;" onclick="return confirm('完了してよろしいですか？')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16"
                                            style="vertical-align: middle;">
                                            <path
                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                    </button>
                                </form>
                                <a class="btn custom-comment-button d-flex justify-content-center align-items-center p-0"
                                    style="width: 40px; height: 40px; color:6ab187; border-color:6ab187;" href="{{ route('comment.create', $task) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                        <path
                                            d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    </svg>
                                </a>
                            @endif
                            </div>
                        </div>
                    </div>
            </div>
    @endforeach
    </div>
    </div>
    @endif
    <div class="text-center">
        <h2 class="mb-5 "
            style="font-size: 2rem; font-weight: 700; color: #333; position: relative; display: inline-block;">
            みんなのTo Do
            <span
                style="display: block; height: 3px; width: 60%; background-color: #DE7a22; margin: 8px auto 0; border-radius: 3px;"></span>
        </h2>
    </div>

    <form action="{{ route('tasks.index') }}" class="mb-4" method="GET" style="width: 60%; margin:auto;"
        id="taskFilterForm">
        <div class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control flex-grow-1" placeholder="検索キーワード"
                value="{{ request('search') }}">
            <button class="btn btn-primary d-flex justify-content-center align-items-center p-0" type="submit"
                style="width: 88px; height: 37px; margin-right:20px; background-color: #20948b;  border:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16" >
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </button>
            <select name="tag" class="form-select" style="width: 180px;"
                onchange="document.getElementById('taskFilterForm').submit();">
                <option value="">全てのタグ</option>
                @foreach (\App\Models\Tag::all() as $tag)
                    <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <select name="sort" class="form-select" style="width: 180px; right:0;"
                onchange="document.getElementById('taskFilterForm').submit();">
                <option value="good" {{ request('sort') == 'good' ? 'selected' : '' }}>いいね数順</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>新しい順</option>
                <option value="important" {{ request('sort') == 'important' ? 'selected' : '' }}>重要度順</option>
                <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>期限日が近い順</option>
            </select>

        </div>
    </form>



    <div class="container mt-4">
        <div class="row mb-5" style="max-width:1200px; margin:auto;">
            @foreach ($tasks as $task)
                <div class="col-md-4 mb-4 " style="position: relative; width:300px;">
                    <div
                        style="display: flex; align-items: center; position: absolute; top: 10px; right: 20px; z-index: 100; background-color: white; padding:5px 8px 5px 5px ; border-radius: 15px;">
                        <img src="{{ asset('storage/' . ($task->user->image_at ?? 'img/default.png')) }}" alt="アイコン"
                            style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 8px;">
                        <span>{{ $task->user->name }}</span>
                    </div>



                    <a href="#" class="task-card" data-title="{{ $task->title }}"
                        data-content="{{ $task->content }}"
                        data-img="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}"
                        data-date="{{ $task->limit }}" style="display:block; text-decoration:none; color:black; "
                        data-bs-toggle="modal" data-bs-target="#taskModal">
                        <div class="card" style="border: 1px ridge #dee2e6;">
                            <img src="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}"
                                class="card-img-top" alt="タスク画像"
                                style="height: 220px; border-bottom:1px ridge #dee2e6">


                    </a>
                    <div class="card-body">



                        <div class="d-flex justify-content-between text-muted px-2 pt-2" style="font-size: 0.8rem;">
                            <small>期限日：{{ $task->limit }}</small>
                            <small>重要度：{{ $task->importance }}</small>
                        </div>
                        <div class="mb-2 mt-2">
                            @foreach ($task->tags as $tag)
                                <span class="badge rounded-pill bg-secondary me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <h5 class="card-title text-center mt-2">{{ $task->title }}</h5>



                        <div class="d-flex justify-content-between">
                            @if (Auth::id() == $task->user_id)
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="btn custom-edit-button d-flex justify-content-center align-items-center p-0"
                                    style="width: 40px; height: 40px; color:f4cc70; border-color:f4cc70;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"
                                        style="vertical-align: middle;">
                                        <path
                                            d="M12.146 0.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-1.5 1.5-3-3 1.5-1.5a.5.5 0 0 1 0-.708zM0 13.5V16h2.5l9.854-9.854-2.5-2.5L0 13.5z" />
                                    </svg>
                                </a>
                                <form method="post" action="{{ route('tasks.destroy', $task->id) }}"
                                    style="margin-bottom: 0;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="btn custom-delete-button d-flex justify-content-center align-items-center p-0"
                                        style="width: 40px; height: 40px; color:de7a22; border-color:de7a22;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"
                                            style="vertical-align: middle;">
                                            <path
                                                d="M5.5 5.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h2.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1z" />
                                        </svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('tasks.complete', $task->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn custom-complete-button d-flex justify-content-center align-items-center p-0"
                                        style="width: 40px; height: 40px; color:20948b; border-color:20948b;" onclick="return confirm('完了してよろしいですか？')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16"
                                            style="vertical-align: middle;">
                                            <path
                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                    </button>
                                </form>
                                <a class="btn custom-comment-button d-flex justify-content-center align-items-center p-0"
                                    style="width: 40px; height: 40px; color:6ab187; border-color:6ab187;" href="{{ route('comment.create', $task) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                        <path
                                            d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    </svg>
                                </a>
                            @endif

                            @if (Auth::id() !== $task->user_id)
                                <div style="display:flex; align-items: center;">
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-outline-success"
                                            style="border: none; background: none;">
                                            <i class="fa-regular fa-heart fa-xl"></i>
                                        </a>
                                        <span class="like-count" style="font-size:15px;">{{ $task->bookmarks_count }}</span>
                                    @else
                                        <button
                                            class="btn {{ Auth::user()->is_bookmark($task->id) ? 'btn-success' : 'btn-outline-success' }} bookmark-toggle"
                                            data-task-id="{{ $task->id }}"
                                            data-bookmarked="{{ Auth::user()->is_bookmark($task->id) ? 'true' : 'false' }}"
                                            style="border: none; background-color: white; width: 40px; padding: 0;">
                                            {!! Auth::user()->is_bookmark($task->id)
                                                ? '<i class="fa-solid fa-heart fa-xl"></i>'
                                                : '<i class="fa-regular fa-heart fa-xl"></i>' !!}
                                        </button>
                                        <span
                                            class="like-count {{ Auth::user()->is_bookmark($task->id) ? 'is-bookmarked' : '' }}"
                                            style="font-size:15px;">
                                            {{ $task->bookmarks_count }}
                                        </span>
                                    @endguest
                                </div>

                                @guest
                                    <a class="btn custom-comment-button d-flex justify-content-center align-items-center p-0"
                                        style="width: 40px; height: 40px; color:B3C100; border-color:B3C100;" href="{{ route('login') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                            <path
                                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                    </a>
                                @else
                                    <a class="btn custom-comment-button d-flex justify-content-center align-items-center p-0"
                                        style="width: 40px; height: 40px; color:6ab187; border-color:6ab187;" href="{{ route('comment.create', $task) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                            <path
                                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                    </a>
                                @endguest
                            @endif

                        </div>
                    </div>
                </div>

        </div>
        @endforeach
    </div>

    <!-- ページネーションを中央に配置 -->
    <div class="d-flex justify-content-center">
        {{ $tasks->links('pagination::bootstrap-5') }}
    </div>
    </div>

    <!-- モーダル -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="taskModalLabel">タスク詳細</h5>

                </div>
                <div class="modal-body text-center"> <!-- タイトルと日時を中央寄せ -->
                    <img id="modalImg" src="" class="img-fluid mb-3 rounded" alt="タスク画像">
                    <div class="d-flex flex-column align-items-center">
                        <h5 id="modalTitle" class="mb-2"></h5>
                        <small class="text-muted" id="modalDate"></small>
                    </div>

                    <p id="modalContent" class="text-start mt-3"></p> <!-- 左端から折り返し -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
@endsection





<script>
    document.addEventListener("DOMContentLoaded", function() {
        // モーダル処理
        const taskCards = document.querySelectorAll(".task-card");
        taskCards.forEach(card => {
            card.addEventListener("click", function() {
                const title = this.getAttribute("data-title");
                const content = this.getAttribute("data-content");
                const imgSrc = this.getAttribute("data-img");
                const date = this.getAttribute("data-date");

                document.getElementById("modalTitle").innerText = title;
                document.getElementById("modalContent").innerText = content;
                document.getElementById("modalImg").src = imgSrc;
                document.getElementById("modalDate").innerText = date;
            });
        });

        // いいね処理（AJAX）
        const buttons = document.querySelectorAll('.bookmark-toggle');
        buttons.forEach(button => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();

                const taskId = button.dataset.taskId;
                const isBookmarked = button.dataset.bookmarked === 'true';
                const countSpan = button.nextElementSibling;
                let currentCount = parseInt(countSpan.innerText);

                // ✅ まずUIを即時変更
                button.classList.toggle('btn-success');
                button.classList.toggle('btn-outline-success');
                button.innerHTML = isBookmarked ?
                    '<i class="fa-regular fa-heart fa-xl"></i>' :
                    '<i class="fa-solid fa-heart fa-xl"></i>';
                button.dataset.bookmarked = isBookmarked ? 'false' : 'true';

                currentCount = isBookmarked ? currentCount - 1 : currentCount + 1;
                countSpan.innerText = currentCount;
                countSpan.classList.toggle('is-bookmarked');

                // 🔄 そのあとサーバー通信
                try {
                    const url = `/bookmarks/${taskId}`;
                    const method = isBookmarked ? 'DELETE' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        alert('サーバーエラーが発生しました。');
                        // エラー時はUIを元に戻す
                        location.reload(); // または元の状態に戻す処理をここで入れる
                    }
                } catch (error) {
                    alert('通信に失敗しました');
                    console.error(error);
                    location.reload(); // 通信失敗したらリロードで整える
                }
            });
        });
    });
</script>
