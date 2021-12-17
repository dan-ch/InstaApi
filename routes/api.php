<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CommentController,
    UserController,
    PostController,
    SearchController
};


// Posts routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/posts', PostController::class);
    Route::match( 'head', '/posts/{post}/like', [PostController::class, 'like']);
    Route::get('/posts/{post}/photo', [PostController::class, 'photo']);
});

// Comments routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/comments', CommentController::class);
});


// Users routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/users', UserController::class)->except(['update', 'store']);
    Route::get('/users/{user}/posts', [UserController::class, 'createdPosts']);
    Route::get('/users/{user}/posts/liked', [UserController::class, 'likedPosts']);
    Route::get('/users/{user}/followers', [UserController::class, 'followers']);
    Route::get('/users/{user}/followed', [UserController::class, 'followed']);
    Route::match('head', '/users/{user}/follow', [UserController::class, 'follow']);
    Route::patch('/users', [UserController::class, 'update']);
});


// Auth routes
Route::group(['prefix' => '/login'], function (){
    Route::post('', [AuthController::class, 'login']);
    Route::get('/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::get('/{provider}/callback', [AuthController::class, 'providerCallback']);
});


// Search routes
Route::middleware('auth:sanctum')->get('/search', SearchController::class);




Route::post('/register', [AuthController::class, 'register']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/password-change', [AuthController::class, 'passwordChange']);
