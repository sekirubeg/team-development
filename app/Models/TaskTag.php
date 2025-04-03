<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTag extends Model
{
    use HasFactory;

    protected $guarded = [];

    // タスクに関連するタグを取得するためのリレーション
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task__tags', 'task_id', 'tag_id');
    }
}
