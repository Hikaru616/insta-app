<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user) {

        $this->user = $user;
    }

    public function index() {

        $all_users = $this->user->withTrashed()->latest()->paginate(10);

        return view('admin.users.index')
                ->with('all_users',$all_users);
    }

    public function deactivate($id) {

        $this->user->destroy($id);

        return redirect()->back();
    }  // destroyとの違いは？

    public function activate($id) {

        $this->user->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }

    public function search(Request $request) {

        $usersQuery = $this->user->withTrashed()
                    ->where('name','like','%'.$request->search . '%')
                    ->where('id', '!=', Auth::user()->id)
                    ->latest();  //get()にするとエラーになる

        $users = $usersQuery->paginate(10)->appends(['search' => $request->search]);


        return view('admin.search')->with('users', $users)->with('search', $request->search);
    }
}
