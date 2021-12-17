<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'posts_count' => 'int',
        'followers_count' => 'int',
        'followed_count' => 'int',
    ];

    public function isFollowed(int $authId){
        return (bool) $this->followers()->where('id', '=', $authId)->first();
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'author_id');
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function followed(){
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function likedPosts(){
        return $this->belongsToMany(Post::class, 'likes');
    }

}
