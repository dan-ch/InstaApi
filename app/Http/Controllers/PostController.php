<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Traits\ResponseApi;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use ResponseApi;

    public function index(): JsonResponse
    {
        $user = Auth::user();
        $posts = Post::query()
            ->whereIn('author_id', $user->followed()->pluck('followed_id'))
            ->with(['author', 'comments.author'])
            ->orderByDesc('created_at')
            ->paginate(10);
        return $this->success($posts);
    }


    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $path = Storage::put('images', $data['photo'], 'public');
        $post =  Post::create([
            'description' => $data['description'] ?? null,
            'tags' => $data['tags'] ?? null,
            'author_id' => $user->id,
            'img_url' => url('storage/'.$path),
        ]);
        $path = '/api/posts/'.$post['id'];
        return $this->success($path, 201);

    }


    public function show(int $postId)
    {
        $result = Post::query()->where('id', $postId)->with('author')
            ->withCount('likes')->first();
        if(!$result)
            return $this->failure("Post not found", 404);
        $isLikedResult = $result;
        return $this->success($isLikedResult);
    }


    public function photo(int $postId)
    {
        $user = Auth::user();
        $post = Post::query()->where('id', $postId)->first();
        if($post){
            $photo = Storage::get('images/'.pathinfo($post->img_url, PATHINFO_BASENAME));
            $post->setAttribute('photo', json_encode($photo));
            $response = Response::make($photo, 200);
            $response->header('Content-Type', 'multipart/form-data');
            return $response;
        }
        return $this->failure("Post not found", 404);
    }


    public function update(UpdatePostRequest $request, int $postId)
    {
        $data = $request->validated();
        $post = Post::find($postId);
        if($post){
            $post->update($data);
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
}
