<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PostService
{

    public function getAllPosts(): array|Collection
    {
        return Post::all();
    }

    public function getPostById(int $id)
    {
        return Post::find($id);
    }

    public function createPost(array $data, int $authorId): Post
    {
        $faker = Factory::create();
        return  Post::create([
            'description' => $data['description'] ?? null,
            'tags' => $data['tags'] ?? null,
            'author_id' => $authorId,
            'img_url' => $faker->url(),
            'min_img_url' => $faker->url(),
        ]);
    }

    public function updatePost(array $data, int $id): bool|int
    {
        $faker = Factory::create();
        $post = Post::find($id);
        return (bool)$post->update([
            'description' => $data['description'] ?: null,
            'tags' => $data['tags'] ?: null,
            'img_url' => $faker->url(),
            'min_img_url' => $faker->url(),
        ]);
    }

    public function deletePostById(int $id): bool
    {
        return Post::destroy($id);
    }
}
