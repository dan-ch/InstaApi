<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Services\PostService;
use App\Http\Traits\ResponseApi;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    use ResponseApi;

    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();
        return $this->success($posts);
    }


    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $post = '/api/posts/'.$this->postService->createPost($data, 2)['id'];
        return $this->success($post, 201);
    }


    public function show(int $postId)
    {
        $result = $this->postService->getPostById($postId);
        if(!$result)
            return $this->failure("Post not found", 404);
        return $this->success($result);
    }


    public function update(UpdatePostRequest $request, int $postId)
    {
        $data = $request->validated();
        $post = $this->postService->updatePost($data, $postId);
        if(!$post)
            return $this->failure("Post not found", 404);
        return $this->success([], 204);
    }

    public function destroy(int $postId)
    {
        $result = $this->postService->deletePostById($postId);
        if(!$result)
            return $this->failure('Post not found', 404);
        return $this->success([], 204);
    }
}
