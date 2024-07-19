<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $post;
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        $popular_posts = $this->getPopularPost();

        return view('users.home')
                ->with('home_posts', $home_posts)
                ->with('suggested_users', $suggested_users)
                ->with('popular_posts', $popular_posts);
    }



    private function getHomePosts() {

        $all_posts = $this->post->latest()->get();
        $home_posts = []; //In case the $home_posts is empty, it will not return NULL, but empty instead

        foreach ($all_posts as $post) {
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    # Get the users that the Auth user is not following
    private function getSuggestedUsers() {

        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user) {
            if(!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users, 0, 5);
        // array_slice(x, y, z)
        // x -- array
        // y -- offset/starting index
        // z -- length/how many
    }

    private function getPopularPost() {

        $all_posts = $this->post->withCount('likes')->orderByDesc('likes_count')->get();
        $popular_posts = [];

        foreach($all_posts as $post) {
            $popular_posts[] = $post;
        }

        return array_slice($popular_posts, 0, 5);
    }

    public function search(Request $request) {

        $users = $this->user
                    ->where('name','like','%'.$request->search . '%')
                    ->where('id', '!=', Auth::user()->id)
                    ->get();

        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
