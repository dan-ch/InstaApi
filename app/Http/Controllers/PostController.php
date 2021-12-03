<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Traits\ResponseApi;
use App\Models\Post;
use Faker\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use ResponseApi;

    public function index(): JsonResponse
    {
        $posts = Post::query()->where('id', '<=', '8')->withCount('likes')->get();
        return $this->success($posts);
    }


    public function store(StorePostRequest $request)
    {
        $faker = Factory::create();
        $data = $request->validated();
        $post =  Post::create([
            'description' => $data['description'] ?? null,
            'tags' => $data['tags'] ?? null,
            'author_id' => $faker->numberBetween(0,10),
            'img_url' => $faker->url(),
            'min_img_url' => $faker->url(),
        ]);
        $path = '/api/posts/'.$post['id'];
        return $this->success($path, 201);
    }


    public function show(int $postId)
    {
        $result = Post::query()->where('id', $postId)->with('author')
            ->withCount('likes')->get();
        if(!$result)
            return $this->failure("Post not found", 404);
        return $this->success($result);
    }


    public function update(UpdatePostRequest $request, int $postId)
    {
        $faker = Factory::create();
        $data = $request->validated();
        $post = Post::find($postId);
        if($post){
            $post->update([
                'description' => $data['description'] ?: null,
                'tags' => $data['tags'] ?: null,
                'img_url' => $faker->url(),
                'min_img_url' => $faker->url(),
            ]);
            return $this->success([], 204);
        }
        return $this->failure("Post not found", 404);
    }

    public function destroy(int $postId)
    {
        $result = Auth::user()->posts()->find($postId)->delete();
        if(!$result)
            return $this->failure('Post not found', 404);
        return $this->success([], 204);
    }
}
