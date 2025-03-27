{{-- あいこさんのヘッダーを表示させるために、layouts/app.blade.phpにextends --}}
@extends('layouts.app')


@section('title', 'プロフィール編集')

{{-- containerが2つ重なっていたため、containerを削除しました。 --}}

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
@section('content')
<div class="profile-container mt-5">
    <div class="profile-card card shadow-lg p-4 profile-edit-card">
        <h2 class="mb-4 text-center text-primary">プロフィールを編集</h2>

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('my_page.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">名前</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="mb-4">
                <label for="image_at" class="form-label">プロフィール画像</label>
                {{-- このonchangeがプレビューを表示させる。 --}}
                <input id="image_at" type="file" class="form-control" name="image_at" onchange="previewImage(this)">
                @if($user->image_at)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $user->image_at) }}" alt="プロフィール画像" class="img-thumbnail" style="max-width: 150px;" id="img">
                    </div>
                @endif
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-5">更新する</button>
                <a href="{{ route('my_page') }}" class="btn btn-secondary ms-2">キャンセル</a>
            </div>
        </form>
    </div>
</div>

{{-- プレビューが表示される実装。onchange属性にpreviewImage(this)を追加 --}}
<script>
  function previewImage(obj)
  {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
      document.getElementById('img').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
  }
</script>
@endsection
