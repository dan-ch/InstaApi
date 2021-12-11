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
});

// Comments routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/comments', CommentController::class);
});


// Users routes
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/users', UserController::class);
    Route::get('/users/{user}/posts', [UserController::class, 'createdPosts']);
    Route::get('/users/{user}/posts/liked', [UserController::class, 'likedPosts']);
    Route::get('/users/{user}/followers', [UserController::class, 'followers'])->withoutMiddleware('auth:sanctum');
    Route::get('/users/{user}/followed', [UserController::class, 'followed'])->withoutMiddleware('auth:sanctum');
    Route::match('head', '/users/{user}/follow', [UserController::class, 'follow']);
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

Route::post('/store-test', [PostController::class, 'photo']);
//Route::get('/store-test', function (){
//    Storage::disk('public')->put('images/file.txt', 'dasdasd');
//});
