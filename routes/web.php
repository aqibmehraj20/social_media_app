<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;




Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>'guest'],function(){
    Route::get('login',[AuthController::class,'index'])->name('login');
    Route::post('login',[AuthController::class,'login'])->name('login')->middleware('throttle:2,1');

    Route::get('register',[AuthController::class,'register_view'])->name('register');
    Route::post('register',[AuthController::class,'register'])->name('register')->middleware('throttle:2,1');

    Route::get('/auth/google',[AuthController::class,'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback',[AuthController::class,'handleGoogleCallback'])->name('handle.google.callback');

});


Route::group(['middleware'=>'auth'],function(){
    Route::get('logout',[AuthController::class,'logout'])->name('logout');


    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/view', [ProfileController::class, 'profile'])->name('profile');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/like', [PostController::class, 'like'])->name('like');
    Route::post('/dislike', [PostController::class, 'dislike'])->name('dislike');
    Route::post('/bookmark', [PostController::class, 'bookmark'])->name('bookmark');

    Route::post('/comment/add', [CommentController::class, 'addComment'])->name('comment.add');
    Route::post('/comment/like',  [CommentController::class, 'likeComment'])->name('comment.like');
    Route::post('/comment/dislike',  [CommentController::class, 'dislikeComment'])->name('comment.dislike');
    Route::get('/post/{postId}', [PostController::class, 'getPostWithComments'])->name('post.show');


});

