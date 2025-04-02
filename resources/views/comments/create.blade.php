@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card shadow p-4 w-70 mx-auto bg-white">
  <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <h2 class=text-center>以下のToDoにコメントします</h2>
          <a href="#" class="task-card shadow" 
                    data-title="{{ $task->title }}" 
                    data-content="{{ $task->content }}" 
                    data-img="{{ asset('img/sample.jpg') }}"  
                    data-date="{{ $task->created_at->format('Y/m/d H:i') }}"  
                    style="display:block; text-decoration:none; color:black; width:350px; margin:40px auto ; "
                    data-bs-toggle="modal" data-bs-target="#taskModal">
                    <div class="card">
                        <img src="{{ $task->image_at ? asset('storage/' . $task->image_at) : asset('storage/img/task.png') }}" class="card-img-top" alt="タスク画像">
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
                        <div style="display: flex; align-items:center; margin-bottom:13px;">
                        <img src="{{ asset('storage/' . Auth::user()->image_at) }}" alt="プロフィール画像" class="profile-icon-small" style="margin-right: 15px;">
                          <p style="margin-bottom: 0;">{{ $comment->user->name }}</p>
                          </div>
                          <p style="font-size:18px; margin-bottom:5px;">{{ $comment->body }}</p>
                          <div style="display: flex; justify-content: space-between; align-items: center;">
                          <small class="text-muted">
                              投稿日：{{ $comment->created_at }}
                          </small>
                          @if (Auth::user()->id === $comment->user_id)
                                <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" >
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm" >削除する</button>
                                </form>
                            @endif
                            </div>
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
                  <textarea class="form-control bg-white"
                            placeholder="内容"
                            rows="5"
                            name="body"></textarea>
              </div>
              <button type="submit" class="btn btn-primary mt-3">コメントする</button>
          </form>
      </div>
  </div>
</div>
</div>
@endsection
