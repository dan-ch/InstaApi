<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
    ];


    public function comments(){
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'author_id');
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'follow', '', '', '' ,'');
    }

    public function followed(){
        return $this->belongsToMany(User::class, 'follow', '', '', '' ,'');
    }

    public function liked(){
        return $this->belongsToMany(Post::class, 'likes', '', '', '' ,'');
    }
}
