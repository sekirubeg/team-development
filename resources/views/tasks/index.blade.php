@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
   
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 不要(Aiko)　--}}
    <style>
        .card-text, #modalContent {
            word-break: break-word;
            white-space: pre-wrap;
            text-align: left; /* 左端から改行 */
        }
        .is-bookmarked{
            color: red;
        }
        .btn-success:hover,
        .btn-success:focus,
        .btn-success:active {
            color: red;
        }
        .btn-success{
            color: red;
        }
        .btn-outline-success:hover,
        .btn-outline-success:focus,
        .btn-outline-success:active {
            color: black;
        }
        .btn-outline-success{
            color: black;
        }
    </style>
@endsection

@section('content')
<h2 class="text-center">みんなのTo Do</h2>

<form action="{{ route('tasks.index') }}" class="mb-4" method="GET" style="width: 80%; margin:auto; ">
    <div class="row" >
        <div class="input-group col-md-8" style="width:800px;">
            <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}" >
        </div>

        <div class="col-md-2">
            <div class="input-group">
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>新しい順</option>
                    <option value="important" {{ request('sort') == 'important' ? 'selected' : '' }}>重要度順</option>
                    <option value="good" {{ request('sort') == 'good' ? 'selected' : '' }}>いいね数順</option>
                    <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>期限日が近い順</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary" tye="submit">検索・ソート</button>
        </div>

    </div>

</form>

<div class="container mt-4">
    <div class="row mb-5">
        @foreach ($tasks as $task)
            <div class="col-md-4 mb-4">
                <a href="#" class="task-card" 
                    data-title="{{ $task->title }}" 
                    data-content="{{ $task->content }}" 
                    data-img="{{ asset('img/sample.jpg') }}"  
                    data-date="{{ $task->limit}}"  
                    style="display:block; text-decoration:none; color:black;"
                    data-bs-toggle="modal" data-bs-target="#taskModal">
                    <div class="card">
                        <img src="{{ asset('img/sample.jpg') }}" class="card-img-top" alt="タスク画像">
                     </a>
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center text-center">
                                <span>{{ $task->title }}</span>
                                <small class="text-muted">期限日：{{ $task->limit }}</small>
                                <small class="text-muted">重要度：{{ $task->importance }}</small>
                            </h5>
                                <p class="card-text text-start mb-3">{{ $task->content }}</p> <!-- ボタンとの間隔を空ける -->
                        <div class="d-flex justify-content-between">
                             @if (Auth::id() == $task->user_id)
                                <a href="#" class="btn btn-primary">Edit</a>
                                <a href="#" class="btn btn-danger">Delete</a>
                            @endif

                    @if (Auth::id() !== $task->user_id)
                        <div style="display:flex; align-items: center;">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-success" style="border: none; background: none;">
                                    <i class="fa-regular fa-heart fa-xl"></i>
                                </a>
                                <span class="like-count" style="font-size:15px;">{{ $task->bookmarks_count }}</span>
                            @else
                                <button 
                                    class="btn {{ Auth::user()->is_bookmark($task->id) ? 'btn-success' : 'btn-outline-success' }} bookmark-toggle"
                                    data-task-id="{{ $task->id }}" 
                                    data-bookmarked="{{ Auth::user()->is_bookmark($task->id) ? 'true' : 'false' }}"
                                    style="border: none; background-color: white; width: 40px; padding: 0;"
                                >
                                    {!! Auth::user()->is_bookmark($task->id) 
                                        ? '<i class="fa-solid fa-heart fa-xl"></i>' 
                                        : '<i class="fa-regular fa-heart fa-xl"></i>' !!}
                                </button>
                                <span class="like-count {{ Auth::user()->is_bookmark($task->id) ? 'is-bookmarked' : '' }}" style="font-size:15px;">
                                    {{ $task->bookmarks_count }}
                                </span>
                            @endguest
                        </div>

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">ログインしてコメント</a>
                        @else
                            <a class="btn btn-primary text-decoration-none text-white" href="{{ route('comment.create', $task) }}">
                                コメント表示
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
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">タスク詳細</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
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
document.addEventListener("DOMContentLoaded", function () {
    // モーダル処理
    const taskCards = document.querySelectorAll(".task-card");
    taskCards.forEach(card => {
        card.addEventListener("click", function () {
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

            const url = `/bookmarks/${taskId}`;
            const method = isBookmarked ? 'DELETE' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                });

                if (response.ok) {
                    // UI更新
                    button.classList.toggle('btn-success');
                    button.classList.toggle('btn-outline-success');
                    button.innerHTML = isBookmarked ? '<i class="fa-regular fa-heart  fa-xl"></i>' : '<i class="fa-solid fa-heart fa-xl"></i>';
                    button.dataset.bookmarked = isBookmarked ? 'false' : 'true';

                    // 2) いいね数を加算/減算
                    if (isBookmarked) {
                        // 取り消し→いいね数 -1
                        currentCount -= 1;
                        countSpan.classList.remove('is-bookmarked');
                    } else {
                        // いいね→いいね数 +1
                        currentCount += 1;
                        countSpan.classList.add('is-bookmarked');
                    }
                    // 新しい数値を表示
                    countSpan.innerText = currentCount;
                } else {
                    alert('通信エラーが発生しました');
                }
            } catch (error) {
                alert('通信に失敗しました');
                console.error(error);
            }
        });
    });
});
</script>

