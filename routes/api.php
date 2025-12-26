<?php

use App\Http\Controllers\CommentsControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JWTMiddleware;


Route::prefix('v1')->group(function () {
    // handle user authentication
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);


    // menghandle posts
    Route::middleware(JWTMiddleware::class)->prefix('posts')->group(function () {
        Route::get('/', [PostsController::class, 'index']); //mengambil semua data posts
        Route::post('/', [PostsController::class, 'store']); //menyimpan data post baru
        Route::get('{id}', [PostsController::class, 'show']); //mengambil data post berdasarkan id
        Route::put('{id}', [PostsController::class, 'update']); //mengupdate data post berdasarkan id
        Route::delete('{id}', [PostsController::class, 'destroy']); //menghapus data post berdasarkan id

    });
    // menghandle comments
    Route::middleware(JWTMiddleware::class)->prefix('comments')->group(function () {
        Route::post('/', [CommentsControler::class, 'store']);
        Route::delete('{id}', [CommentsControler::class, 'destroy']);
    });
    // menghandle likes
    Route::middleware(JWTMiddleware::class)->prefix('likes')->group(function () {
        Route::post('/', [LikesController::class, 'store']); //menyimpan data like baru
        Route::delete('{id}', [LikesController::class, 'destroy']); //menghapus data like berdasarkan id
    });

    // menghandle messages
    Route::middleware(JWTMiddleware::class)->prefix('messages')->group(function () {
        Route::post('/', [MessagesController::class, 'store']); //menyimpan data message baru
        Route::get('{id}', [MessagesController::class, 'show']); //mengambil atau melihat data message berdasarkan id
        Route::get('/getMessages/{user_id}', [MessagesController::class, 'getMessages']); //menampilkan pesan berdasrakan user_id
        Route::delete('{id}', [MessagesController::class, 'destroy']); //menghapus data message berdarkan id
    });
});
