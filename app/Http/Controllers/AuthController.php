<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Traits\ResponseApi;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ResponseApi;

    public function register(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $token = $user->createToken('InstaKilogramApiToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->success($response, 201);
    }


    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            $this->failure(['message' => 'Invalid credentials'], 401);
        }
        $user->tokens()->delete();
        $token = $user->createToken('InstaKilogramApiToken')->plainTextToken;
        return $this->success([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->success(['message' => 'Logged out']);
    }
}
