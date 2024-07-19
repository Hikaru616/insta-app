<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function user() {

        return $this->belongsTo(User::class)->withTrashed();
    }

    public function categoryPost() {

        return $this->hasMany(CategoryPost::class);
    }

    public function hasCategoryPost(){

        return $this->categoryPost()->exists();
    }

    public function comments() {

        return $this->hasMany(Comment::class);
    }

    public function likes() {

        return $this->hasMany(Like::class);
    }

    public function isLiked() {

        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    public function countCategory() {

    return $this->categoryPost()->count();
    }

    // public function countPosts() {

    //     return $this->totalPosts = Post::count();
    // }
}
