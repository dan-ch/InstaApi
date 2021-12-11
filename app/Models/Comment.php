<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'post_id', 'author_id', 'parent_comment_id'];

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function parentComment(){
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function childrenComments(){
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function post(){
        return $this->hasOne(Post::class, 'post_id');
    }
}
