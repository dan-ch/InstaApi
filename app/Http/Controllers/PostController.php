<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Traits\ResponseApi;
use App\Models\Post;
use Faker\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use ResponseApi;

    public function index(): JsonResponse
    {
        $user = Auth::user();
        $posts = Post::query()->where('id', '<=', '8')->withCount('likes')
            ->with(['author', 'comments.author'])->get();
        foreach ($posts as $post){
            $post->setAttribute('isLiked', $post->isLiked($user->id));
        }
        return $this->success($posts);
    }


    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $path = Storage::disk('public')->put('images', $data['photo']);
        Storage::put('images', $data['photo']);
        $post =  Post::create([
            'description' => $data['description'] ?? null,
            'tags' => $data['tags'] ?? null,
            'author_id' => $user->id,
            'img_url' => url('storage/'.$path),
            'min_img_url' => '$faker->url()',
        ]);
        $path = '/api/posts/'.$post['id'];
        return $this->success($path, 201);
    }


    public function show(int $postId)
    {
        $user = Auth::user();
        $result = Post::query()->where('id', $postId)->with('author')
            ->withCount('likes')->first();
        if(!$result)
            return $this->failure("Post not found", 404);
        $isLikedResult = $result->setAttribute('isLiked', $result->isLiked($user->id));
        return $this->success($isLikedResult);
    }


    public function update(UpdatePostRequest $request, int $postId)
    {
        $data = $request->validated();
        $post = Post::find($postId);
        Storage::put('images', $data['photo']);
        if($post){
            $post->update([
                'description' => $data['description'] ?: null,
                'tags' => $data['tags'] ?: null,
                'img_url' => '',
                'min_img_url' => '',
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

    public function like(int $postId){
        $user = Auth::user();
        Post::query()->where('id', '=', $postId)->first()->likes()->toggle($user->id);
    }

    public function photo (Request $request){
      return $this->success(["sdsd" => "dsa"], 222);
    }
}
