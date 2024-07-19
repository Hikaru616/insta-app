<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name'];

    public function categoryPost() {

        return $this->hasMany(CategoryPost::class);
    } //カテゴリーcountするために必須　→　何で？？

    public function categoryPostCount($category_id) {

    return $this->categoryPost($category_id)->count();
}

    public function uncategorizedCount() {

        return Post::doesntHave('categoryPost')->count();
    }

}
