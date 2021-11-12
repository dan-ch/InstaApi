<?php

declare(strict_types=1);

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{

    public function run(): void
    {
        $faker = Factory::create();
        $posts = [];

        DB::table('posts')->truncate();

        for($i = 0; $i < 100; $i++) {
          $posts[] = [
              'description' => $faker->text(150),
              'img_url' => $faker->url(),
              'min_img_url' => $faker->url(),
              'tags' => $faker->words($faker->numberBetween(2, 10), true),
              'author_id' => $faker->numberBetween(1, 10),
              'created_at' => $faker->dateTime(),
              'updated_at' => $faker->dateTime()
          ];
        }
        DB::table('posts')->insert($posts);
    }
}
