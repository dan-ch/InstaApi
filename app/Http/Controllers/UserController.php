<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseApi;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function show(int $userId)
    {
        sleep(1);
        $authUser = Auth::user();
        $user = User::query()->withCount(['posts', 'followers', 'followed'])->find($userId);
        if($user){
            $user->setAttribute('isFollowed', $user->isFollowed($authUser->id));
            return $this->success($user);
        }
        return $this->failure('User not found', 404);
    }

    public function createdPosts(int $userId){
        $result = Post::query()->where('author_id', '=', $userId)
            ->withCount(['likes', 'comments'])->with('comments.author')->get();
        return $this->success($result);
    }

    public function likedPosts(int $userId){
        $result = User::query()->find($userId)->likedPosts;
        return $this->success($result);
    }

    public function followers(int $userId){
        $result = User::query()->find($userId)->followers;
        return $this->success($result);
    }

    public function followed(int $userId){
        $result = User::query()->find($userId)->followed;
        return $this->success($result);
    }

    public function update(Request $request)
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

    public function follow(int $userId){
        $user = Auth::user();
        User::find($userId)->followers()->toggle($user->id);
    }
}
