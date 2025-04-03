@extends('layouts.app')

@section('style')
<style>
    .container {
        max-width: 500px;
        margin-top: 20px;
    }

    .form-group {
        margin-bottom: 20px; 
    }

    h1 {
        margin-bottom: 30px;
    }
</style>
@endsection

@section('content')
    <div class="container" style="width:700px;">
        <h1>タスク作成</h1>

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">タイトル:</label>
                <input type="text" id="title" name="title" class="form-control"value="{{ old('title') }}">
            </div>
            @error('title')
                <div class="text-danger mt-2 mb-2">{{ $message }}</div>
                
            @enderror
            
            <div class="form-group">
                <label for="content">内容:</label>
                <textarea id="content" name="content" rows="4" class="form-control"value="{{ old('content') }}"></textarea>
            </div>
            @error('content')
                <div class="text-danger mt-2 mb-2">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="priority">優先度:</label>
                <select id="priority" name="importance" class="form-control">
                    <option value="" selected>選択してください</option> 
                    <option value="1">低</option>
                    <option value="2">中</option>
                    <option value="3">高</option>
                </select>
            </div>
            @error('importance')
                <div class="text-danger mt-2 mb-2">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="due_date">期限:</label>
                <input type="date" id="due_date" name="limit" class="form-control"value="{{ old('limit') }}">
            </div>
            @error('limit')
                <div class="text-danger mt-2 mb-2">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="image">画像アップロード:</label>
                <input type="file" id="image" name="image_at" class="form-control-file">
                <img id="preview" style="max-width: 150px; max-height: 150px; margin-top: 10px; display:none;">
            </div>
            @error('image_at')
                <div class="text-danger mt-2 mb-2">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary">作成</button>
        </form>
    </div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#image').on('change', function(){
            var file = this.files[0];

            if (!file) return;
            if (!file.type.startsWith('image/')) {
                alert('画像ファイルを選択してください');
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e){
                $('#preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
