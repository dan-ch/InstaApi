<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CommentController,
    UserController,
    PostController,
};


// Posts routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/posts', PostController::class)->withoutMiddleware('auth:sanctum');
});


// Comments routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/comments', CommentController::class);
});

// Users routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/users', UserController::class);
    Route::get('/users/{user}/posts', [UserController::class, 'posts']);
});


// Auth routes
Route::group(['prefix' => '/login'], function (){
    Route::post('', [AuthController::class, 'login']);
    Route::get('/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::get('/{provider}/callback', [AuthController::class, 'providerCallback']);
    Route::post('/password-reset', [AuthController::class, 'passwordReset']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);
