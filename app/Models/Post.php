<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'description',
        'img_url',
        'min_img_url',
        'tags',
        'author_id'
    ];

    protected $casts = [
        'author_id' => 'integer',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'created_at' => 'timestamp'
    ];

    protected $withCount = [
        'likes',
        'comments'
    ];

    protected $appends =[
        'isLiked'
    ];


    public function getIsLikedAttribute(){
        $userId = Auth::id();
        return $this->isLiked($userId);
    }

    public function isLiked(int $authId){
        $post = $this->likes()->where('id', '=', $authId)->first();
        return (bool) $post;
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'likes');
    }

}
