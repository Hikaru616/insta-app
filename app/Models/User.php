<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;///???????????????????????????
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignabΩle.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts() {

        return $this->hasMany(Post::class)->latest();
    }


 //??????????????????????????????????????????????????????????
    public function followers() {

        return $this->hasMany(Follow::class, 'following_id');
    }

    public function following() {

        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function isFollowed() {

        return $this->followers()->where('follower_id',Auth::user()->id)->exists();
    }

    public function countUsers() {

        // return $this->totalUsers = User::count();
        return User::count();

    } //なんで　return User::count();だけだとエラーが起こる？

    public function countPosts() {

        // return $this->totalPosts = Post::count();
        return Post::count();

    }

    public function countCategories() {

        // return $this->totalCategories = Category::count();
        return Category::count();

    }


}
