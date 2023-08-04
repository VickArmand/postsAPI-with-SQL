<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
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

    Route::get('/posts', [PostsController::class, 'index']);

    Route::get('/posts/id/{id?}', [PostsController::class, 'show']);

    Route::post('/posts/create', [PostsController::class, 'store']);

    Route::put('/posts/edit/id/{id?}', [PostsController::class, 'update']);

    Route::delete('/posts/delete/id/{id?}', [PostsController::class, 'destroy']);

    Route::post('/logout', [UsersController::class, 'logout']);
    Route::get('/posts/search/{slug?}', [PostsController::class, 'search']);

});
Route::post('/login', [UsersController::class, 'login']);
Route::post('/register', [UsersController::class, 'register']);
Route::get('/users', [UsersController::class, 'index']);
Route::delete('/users/delete/id/{id?}', [UsersController::class, 'destroy']);