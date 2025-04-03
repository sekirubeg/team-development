@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ログイン') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        
                    @endif

                    <div class="alert alert-success">
                        ログインに成功しました！３秒後にタスクページに移動します。  
                        <p>自動で移動しない場合は、<a href="{{ url('/tasks') }}">こちら</a>をクリックしてください。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<meta http-equiv="refresh" content="4;url={{ url('/tasks') }}">

<script>
    setTimeout(function() {
        window.location.href = "{{ url('/tasks') }}";
    }, 3000);
</script>
@endsection
