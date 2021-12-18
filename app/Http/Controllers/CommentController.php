<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Traits\ResponseApi;
use App\Models\Comment;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use ResponseApi;

    public function index()
    {
        return Comment::all();
    }


    public function store(StoreCommentRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();
        $data['author_id'] = $userId;
        $comment = Comment::create($data);
        $location = '/comments/'.$comment['id'];
        return $this->success(['location' => $location], 201);
    }


    public function show(int $commentId)
    {
       $comment = Comment::query()->with('author')->find($commentId);
       if($comment)
           return $this->success($comment);
       return $this->failure('Comment not found', 404);
    }


    public function update(UpdateCommentRequest $request, int $commentId)
    {
        $data = $request->validated();
        $comment = Comment::find($commentId);
        if($comment){
            $comment->fill($data)->save();
            return $this->success([], 204);
        }
        return $this->failure("Comment not found", 404);
    }


    public function destroy(int $commentId)
    {
        $user = Auth::user();
        $result = $user->comments()->where('id', '=', $commentId)->delete();
        if($result)
            return $this->success([],204);
        return $this->failure('Comment not found', 404);
    }
}
