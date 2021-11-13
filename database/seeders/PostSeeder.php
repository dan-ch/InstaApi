<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('posts')->truncate();

        $posts = Post::factory()->count(100)->make();

        DB::table('posts')->insert($posts->toArray());
    }
}
