<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:sanctum')->get('/test', function (){
    return response()->json('Protected route', 201);
});


// Posts routes
Route::group([
    'prefix' => '/posts',
    'as' => 'posts.',
    ], function (){

    Route::get('/', [PostController::class, 'index'])
    ->name('all');

    Route::get('/{postId}', [PostController::class, 'show']);

    Route::post('/', [PostController::class, 'store']);

    Route::delete('/{postId}', [PostController::class, 'destroy']);

    Route::match(['patch', 'put'], '/{postId}', [PostController::class, 'update']);

});

// Comments routes

Route::apiResource('/comments', CommentController::class);


// Users routes
Route::apiResource('/users', UserController::class);


// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);

Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [AuthController::class, 'providerCallback']);
