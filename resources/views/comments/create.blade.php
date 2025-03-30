@extends('layouts.app')
@section('content')
<div class="container">
      
  <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <h2>以下のToDoにコメントします</h2>
          <a href="#" class="task-card" 
                    data-title="{{ $task->title }}" 
                    data-content="{{ $task->content }}" 
                    data-img="{{ asset('img/sample.jpg') }}"  
                    data-date="{{ $task->created_at->format('Y/m/d H:i') }}"  
                    style="display:block; text-decoration:none; color:black; width:350px; margin:40px auto ; "
                    data-bs-toggle="modal" data-bs-target="#taskModal">
                    <div class="card">
                        <img src="{{ asset('img/sample.jpg') }}" class="card-img-top" alt="タスク画像">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center text-center">
                                <span>{{ $task->title }}</span>
                                <small class="text-muted">{{ $task->created_at->format('Y/m/d H:i') }}</small>
                            </h5>
                                <p class="card-text text-start mb-3">{{ $task->content }}</p> 
                        </div>
                    </div>
          </a>
          <!-- コメント一覧表示部分 -->
          <div class="mt-4">
              <h4>コメント一覧</h4>
              @forelse ($task->comments as $comment)
                  <div class="card mb-2">
                      <div class="card-body">
                          <p>{{ $comment->user->name }}</p>
                          <p>{{ $comment->body }}</p>
                          <small class="text-muted">
                              投稿日：{{ $comment->created_at }}
                          </small>
                      </div>
                  </div>
              @empty
                  <p>まだコメントがありません。</p>
              @endforelse
          </div>
      </div>
  </div>

  {{-- コメント投稿フォーム --}}
  <div class="row justify-content-center mt-5">
      <div class="col-md-8">
          <form action="{{ route('comment.store') }}" method="post">
              @csrf
              {{-- Task側のIDを hidden で渡す（ルーティングにより異なる場合も） --}}
              <input type="hidden" name="task_id" value="{{ $task->id }}">

              <div class="form-group">
                  <label>コメント</label>
                  <textarea class="form-control"
                            placeholder="内容"
                            rows="5"
                            name="body"></textarea>
              </div>
              <button type="submit" class="btn btn-primary mt-3">コメントする</button>
          </form>
      </div>
  </div>
</div>
@endsection
