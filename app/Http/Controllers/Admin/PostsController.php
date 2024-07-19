<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;


class PostsController extends Controller
{
    private $post;
    private $user;

    public function __construct(Post $post, User $user) {

        $this->post = $post;
        // $this->user = $user;
    }

    public function index() {

        $all_posts = $this->post->withTrashed()->latest()->paginate(10);
        // $all_users = $this->user->withTrashed()->latest()->get();

        return view('admin.posts.index')
                ->with('all_posts',$all_posts);
    }

    public function deactivate($id) {

        $this->post->destroy($id);

        return redirect()->back();
    }

    public function activate($id) {

        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }
}
