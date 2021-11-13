<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->truncate();

        $comments = Comment::factory()->count(300)->make();

        DB::table('comments')->insert($comments->toArray());
    }
}
