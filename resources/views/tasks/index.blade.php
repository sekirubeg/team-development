<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/tasks.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/sample.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">タイトル : {{ $task->title }}</h5>
                            <p class="card-text">内容 : {{ $task->content }}</p>
                            <a href="#" class="btn btn-primary">Edit</a>
                            <a href="#" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>