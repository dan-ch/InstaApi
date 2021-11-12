<?php

declare(strict_types=1);

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Services\PostService;
use App\Http\Traits\ResponseApi;
class PostController extends Controller
{
    use ResponseApi;

    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return $this->success('All posts returned', $posts);
    }


    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $post = '/api/posts/'.$this->postService->createPost($data, 2)['id'];
        return $this->success('Post crested', $post, 201);
    }


    public function show(int $postId)
    {
        $result = $this->postService->getPostById($postId);
        if(!$result)
            return $this->failure("Post not found", 404);
        return $this->success('Post returned', $result);
    }


    public function update(UpdatePostRequest $request, int $postId)
    {
        $data = $request->validated();
        $post = $this->postService->updatePost($data, $postId);
        if(!$post)
            return $this->failure("Post not updated");
        return $this->success("Post updated", []);
    }

    public function destroy(int $postId)
    {
        $result = $this->postService->deletePostById($postId);
        if($result)
            return $this->success("Post deleted", []);
        return $this->failure('Post not found', 400);
    }
}
