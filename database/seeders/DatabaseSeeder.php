<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Post::disableSearchSyncing();
        User::disableSearchSyncing();
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            CommentSeeder::class
        ]);
        Post::all()->searchable();
        User::all()->searchable();
        Post::enableSearchSyncing();
        User::enableSearchSyncing();
    }
}
