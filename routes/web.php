<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/people', [HomeController::class, 'search'])->name('search');



    # POST
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

    # COMMENT
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{post_id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    # Profile
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');
    Route::get('/profile/{id}/suggestion', [ProfileController::class, 'suggestion'])->name('profile.suggestion');
    Route::get('/profile/{id}/pass', [ProfileController::class, 'pass'])->name('profile.pass');
    Route::patch('/profile/editpass', [ProfileController::class, 'editpass'])->name('profile.editpass');



    # Like
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    #Follow
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    #ADMIN
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
        //USER
        Route::get('/users',[UsersController::class, 'index']) ->name('users');
        Route::delete('/users/{id}/deactivate',[UsersController::class, 'deactivate']) ->name('users.deactivate');
        Route::patch('/users/{id}/activate',[UsersController::class, 'activate']) ->name('users.activate');
        Route::get('/people', [UsersController::class, 'search'])->name('search');

        //POST
        Route::get('/posts',[PostsController::class, 'index']) ->name('posts');
        Route::delete('/posts/{id}/deactivate',[PostsController::class, 'deactivate']) ->name('posts.deactivate');
        Route::patch('/posts/{id}/activate',[PostsController::class, 'activate']) ->name('posts.activate');


        //CATEGORY
        Route::get('/categories',[CategoriesController::class, 'index']) ->name('categories');
        Route::post('/categories/store',[CategoriesController::class, 'store']) ->name('categories.store');
        Route::patch('/categories/{id}/update',[CategoriesController::class, 'update']) ->name('categories.update');
        Route::delete('/categories/{id}/destroy',[CategoriesController::class, 'destroy']) ->name('categories.destroy');

    });

});
