<?php

use App\Http\Controllers\CommentsControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\CommentsController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    // menghandle posts
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostsController::class, 'index']); //mengambil semua data posts
        Route::post('/', [PostsController::class, 'store']); //menyimpan data post baru
        Route::get('{id}', [PostsController::class, 'show']); //mengambil data post berdasarkan id
        Route::put('{id}', [PostsController::class, 'update']); //mengupdate data post berdasarkan id
        Route::delete('{id}', [PostsController::class, 'destroy']); //menghapus data post berdasarkan id

    });

    Route::prefix('comments')->group(function () {
        Route::post('/', [CommentsControler::class, 'store']);
        Route::delete('{id}', [CommentsControler::class, 'destroy']);
    });
});
