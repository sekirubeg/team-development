<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'description',
        'password',
        'image_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function bookmarks()
    {
        return $this->belongsToMany(Task::class, 'bookmarks', 'user_id', 'task_id')->withTimestamps();
    }
    public function bookmark($taskId)
    {
        $exist = $this->is_bookmark($taskId);
        if ($exist) {
            return false;
        } else {
            $this->bookmarks()->attach($taskId);
            return true;
        }
    }
    public function unbookmark($taskId)
    {
        $exist = $this->is_bookmark($taskId);
        if ($exist) {
            $this->bookmarks()->detach($taskId);
            return true;
        } else {
            return false;
        }
    }
    public function is_bookmark($taskId)
    {
        return $this->bookmarks()->where('task_id', $taskId)->exists();
    }







    public function task_tags()
    {
        return $this->hasMany(Task_Tag::class);
    }

}
