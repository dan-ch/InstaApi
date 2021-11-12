<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;

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

Route::get('/test', function () {
    return response('test', 200)
        ->header('Content-Type', 'text/plain');
});

// POSTS Routes
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
