<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    /** @use HasFactory<\Database\Factories\BookmarksFactory> */
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
