<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

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
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'likes');
//        return $this->belongsToMany(User::class, 'likes', 'kluczObcyTegoModeluWPivotTable',
//            'kluczObcyTegoModeluPowiazanego(np.User)WPivotTable', '' ,'');
    }

}
