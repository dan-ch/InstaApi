<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseApi;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseApi;

    public function index()
    {
        return $this->success(User::all());
    }


    public function store(Request $request)
    {
        return null;
    }


    public function show(int $commentId)
    {
        $user = User::find($commentId);
        if($user)
            return $this->success($user);
        return $this->failure('User not found', 404);
    }

    public function posts(int $userId){
        $result = Post::query()->where('author_id', '=', $userId)->get();
        return $this->success($result);
    }


    public function update(Request $request, $id)
    {
        return null;
    }


    public function destroy(int $userId)
    {
        $result = User::destroy($userId);
        if($result)
            return $this->success([],204);
        return $this->failure('User not found', 404);
    }
}
