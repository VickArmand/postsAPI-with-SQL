<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's

    Route::get('/posts', [PostsController::class, 'getPosts']);

    Route::get('/posts/id/{id?}', [PostsController::class, 'readPost']);

    Route::post('/posts/create', [PostsController::class, 'createPost']);

    Route::put('/posts/edit/id/{id?}', [PostsController::class, 'editPost']);

    Route::delete('/posts/delete/id/{id?}', [PostsController::class, 'deletePost']);

    Route::post('/logout', [UserController::class, 'logout']);
});
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
