<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Traits\ResponseApi;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Hash;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Nette\Utils\Random;

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

    public function redirectToProvider(string $provider): JsonResponse
    {
        if ($this->validateProvider($provider)) {
            return $this->failure(['message' => 'Invalid provider. Use Google, Github or TikTok']);
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function providerCallback(string $provider)
    {
        $validated = $this->validateProvider($provider);
        if (!$validated) {
            return $this->failure(['message' => 'Invalid provider. Use Google, Github or TikTok']);
        }
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return $this->failure(['error' => 'Invalid credentials provided.'], 422);
        }

        //dd($user);
        $userCreated = User::query()->firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => Carbon::now(),
                'name' => $user->getName() ?? $user->user['login'],
                'avatar' => $user->getAvatar(),
                'password' => Hash::make(Random::generate(15)),
            ]
        );

        $userCreated->tokens()->delete();
        $token = $userCreated->createToken('InstaKilogramApiToken')->plainTextToken;

        return $this->success([
            'user' => $userCreated,
            'token' => $token
        ]);
    }

    private function validateProvider($provider)
    {
        return in_array($provider, ['facebook', 'github', 'google', 'tiktok']);
    }
}
