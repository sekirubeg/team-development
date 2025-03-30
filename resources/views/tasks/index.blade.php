@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/tasks.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .card-text, #modalContent {
            word-break: break-word;
            white-space: pre-wrap;
            text-align: left; /* 左端から改行 */
        }
    </style>
     
@endsection

@section('content')
<h2 class="text-center">みんなのTo Do</h2>

<div class="container mt-4">
    <div class="row mb-5">
        @foreach ($tasks as $task)
            <div class="col-md-4 mb-4">
                <a href="#" class="task-card" 
                    data-title="{{ $task->title }}" 
                    data-content="{{ $task->content }}" 
                    data-img="{{ asset('img/sample.jpg') }}"  
                    data-date="{{ $task->created_at->format('Y/m/d H:i') }}"  
                    style="display:block; text-decoration:none; color:black;"
                    data-bs-toggle="modal" data-bs-target="#taskModal">
                    <div class="card">
                        <img src="{{ asset('img/sample.jpg') }}" class="card-img-top" alt="タスク画像">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center text-center">
                                <span>{{ $task->title }}</span>
                                <small class="text-muted">{{ $task->created_at->format('Y/m/d H:i') }}</small>
                            </h5>
                                <p class="card-text text-start mb-3">{{ $task->content }}</p> <!-- ボタンとの間隔を空ける -->
                        <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-primary">Edit</a>
                                <a href="#" class="btn btn-danger">Delete</a>
                                
                                <div>
    @if (Auth::id() !== $task->user_id)
        <button 
            class="btn {{ Auth::user()->is_bookmark($task->id) ? 'btn-success' : 'btn-outline-success' }} bookmark-toggle" 
            data-task-id="{{ $task->id }}" 
            data-bookmarked="{{ Auth::user()->is_bookmark($task->id) ? 'true' : 'false' }}"
        >
            {{ Auth::user()->is_bookmark($task->id) ? 'いいねを取り消す' : 'いいね' }}
        </button>
    @endif
</div>


</button>
    </div>
</div>

                    </div>
                </a>
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
                    button.textContent = isBookmarked ? 'いいね' : 'いいねを取り消す';
                    button.dataset.bookmarked = isBookmarked ? 'false' : 'true';
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

